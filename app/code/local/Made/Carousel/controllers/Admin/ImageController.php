<?php

class Made_Carousel_Admin_ImageController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('cms/carousel')
                ->_addBreadcrumb(Mage::helper('carousel')->__('Carousel'), $this->getUrl('*/*/'));
        return $this;
    }

    public function indexAction() {
        $this->_initAction()
                ->_addContent($this->getLayout()->createBlock('carousel/admin_image'))
                ->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction() {
        $this->_title($this->__('carousel'));
        $id = $this->getRequest()->getParam('image_id');
        $model = Mage::getModel('carousel/image');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('carousel')->__('This image no longer exists'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        Mage::register('carousel_image', $model);
        $this->_initAction()
                ->_addBreadcrumb($id ? Mage::helper('carousel')->__('Edit Image') : Mage::helper('carousel')->__('New Image'), $id ? Mage::helper('carousel')->__('Edit Image') : Mage::helper('carousel')->__('New Image'))
                ->_addContent($this->getLayout()->createBlock('carousel/admin_image_edit')->setData('action', $this->getUrl('*/admin_image/save')))
                ->_addLeft($this->getLayout()->createBlock('carousel/admin_image_edit_tabs'))
                ->renderLayout();
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            try {
                if (isset($_FILES['image_src']['name']) && $_FILES['image_src']['name'] != "") {
                    $new_image = $_FILES;
                    $data['image_src'] = $this->_saveImage($new_image);
                }
                if (is_array($data['image_src']))
                    $data['image_src'] = $data['image_src']['value'];
                $data['image_id'] = $this->getRequest()->getParam('image_id');
                if ($this->getRequest()->getParam('image_id'))
                    $model = Mage::getModel('carousel/image')->load($this->getRequest()->getParam('image_id'));
                else {
                    $model = Mage::getModel('carousel/image');
                }
                $model->setData($data);
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('carousel')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('image_id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('image_id' => $this->getRequest()->getParam('image_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($id = $this->getRequest()->getParam('image_id')) {
            $name = "";
            try {
                $model = Mage::getModel('carousel/image');
                $model->load($id);
                $name = $model->getName();
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('carousel')->__('Image was successfully deleted'));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('image_id' => $id));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('carousel')->__('Unable to find a image to delete'));
        $this->_redirect('*/*/');
    }

    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('carousel/image');
    }

    public function massStatusAction() {
        $imageIds = $this->getRequest()->getParam('massaction');
        if (!is_array($imageIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select image(s)'));
        } else {
            try {
                foreach ($imageIds as $imageId) {
                    $model = Mage::getSingleton('carousel/image')
                            ->load($imageId)
                            ->setIs_active($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) were successfully updated', count($imageIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massDeleteAction() {
        $imageIds = $this->getRequest()->getParam('massaction');
        if (!is_array($imageIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('carousel')->__('Please select image(s)'));
        } else {
            try {
                foreach ($imageIds as $imageId) {
                    $mass = Mage::getModel('carousel/image')->load($imageId);
                    $mass->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('carousel')->__(
                                'Total of %d record(s) were successfully deleted', count($imageIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction() {
        $fileName = 'image.csv';
        $content = $this->getLayout()->createBlock('carousel/admin_image_grid')
                ->getCsv();
        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction() {
        $fileName = 'image.xml';
        $content = $this->getLayout()->createBlock('carousel/admin_image_grid')
                ->getXml();
        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream') {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }

    protected function _saveImage($new_image) {
        if (isset($new_image['image_src']['name']) && (file_exists($new_image['image_src']['tmp_name']))) {
            try {
                $uploader = new Varien_File_Uploader('image_src');
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $path = Mage::getBaseDir('media') . DS;
                $uploader->save($path, $new_image['image_src']['name']);
                return $new_image['image_src']['name'];
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        Mage::getSingleton('adminhtml/session')->addError("No image file was uploaded");
        return false;
    }

}
