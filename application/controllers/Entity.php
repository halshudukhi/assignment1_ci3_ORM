<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('RABBITORM_DEBUG', true);

class Entity extends CI_Controller {
        
	public function retrieveParents()
	{
                $this->load->model('entityModel', '', TRUE);
                
                $entities = $this->entityModel->retrieveParents();

                echo json_encode($entities);
        }
        
        public function generateChildren()
        {
                $selectedParentID = isset($_POST['parent']) && is_numeric($_POST['parent']) ? (int)$_POST['parent'] : 0;

                $response['isSuccessful'] = false;

                $response['token'] = $this->security->get_csrf_hash();

                $response['children'] = [];

                $newSubCatID = $newParentChildCategoryID = 0;

                if(!empty($selectedParentID) && is_numeric($selectedParentID) && $selectedParentID > 0)
                {
                        $category = Category::find($selectedParentID);
                        if(!empty($category))
                        {
                                $subCats = $this->namingSubs($category->categoryName);
                                
                                $safeToSave = false;

                                foreach($subCats as $subCat)
                                {
                                        $subCategory =  new Category;
                                        $subCategory->categoryName = $subCat['name'];
                                        $subCategory->isParent = 0;
                                        $subCategory->save();
                                        
                                        $newSubCatID = (int)$subCategory->idCategory;
                                        
                                        $parentChildCategory = new Subs;
                                        $parentChildCategory->idParent = $selectedParentID;
                                        $parentChildCategory->idChild = $newSubCatID;
                                        $parentChildCategory->save();

                                        $newParentChildCategoryID = $parentChildCategory->idSub;
                                }
                                $response['isSuccessful'] = true;
                                $children = Subs::where('idParent', $selectedParentID)->get();
                                
                                foreach($children as &$child)
                                {
                                        $parent = Category::where('idCategory', $child->idChild)->get();
                                        $child->categoryName = $parent[0]->categoryName;
                                }
                                $response['children'] = $children; 
                                        
                        }
                }
                
                unset($_POST);
                echo json_encode($response);
        }

        private function namingSubs($key)
        {
                $initialSubCreation = true;

                $subCat = "SUB $key";

                $keyAsArray = explode(' ', $subCat);

                if(isset($keyAsArray[0]) && isset($keyAsArray[1]) && $keyAsArray[0] == $keyAsArray[1])
                {
                        $initialSubCreation = false;
                }

                $subCats = [
                        [
                                'name' => $initialSubCreation? $subCat . '1' : $subCat . '-1',
                        ],
                        [
                                'name' => $initialSubCreation? $subCat . '2' : $subCat . '-2',
                        ]
                ];

                return $subCats;
        }
}