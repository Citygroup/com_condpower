<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modela');
 
/**
 * Exim Model
 */
class CondpowerModelExim extends JModel
{
        private function _save($data)
        {
            $table = $this->getTable('vmcat');
            // Bind the data.
            if (!$table->bind($data))
            {
                    $this->setError($table->getError());
                    return false;
            }
            // Check the data.
            if (!$table->check())
            {
                    $this->setError($table->getError());
                    return false;
            }

            // Store the data.
            if (!$table->store())
            {
                    $this->setError($table->getError());
                    return false;
            }
            return TRUE;
    }
    /**
     * @return query
     */
    private function _buils_export_query($custom_field)
    {
        $cids = JRequest::getVar('cid', array(), '', 'array');
        $query = $this->_db->getQuery(true);
        $query->select($custom_field['virtuemart_custom_id'].' AS `virtuemart_custom_id`');
        $query->select('products_ru_ru.virtuemart_product_id');
        $query->select('products_ru_ru.product_name');
        $query->select('product_custom_plg_param.intvalue');
        $query->select('"'.$custom_field['custom_title'].'" AS `custom_title`');
        $query->from('#__virtuemart_products_ru_ru AS products_ru_ru');
        $query->leftjoin('#__virtuemart_product_custom_plg_param AS product_custom_plg_param'.
                        ' ON product_custom_plg_param.virtuemart_product_id = products_ru_ru.virtuemart_product_id'.
                        ' AND product_custom_plg_param.virtuemart_custom_id = '.$custom_field['virtuemart_custom_id']
        );
        $query->where('products_ru_ru.virtuemart_product_id IN ('.implode(',',$cids).')');
        return $query;
    }

    /**
	 * Method to export CSV data from table virtuemart_product_custom_plg_param
	 *
	 * @param	array of id custom_fields
	 * @return	array of custom_fields
	 * @since	0.0.1
         * @author	Konstantin Ovcharenko
	 */
        private function _build_a_custom_fields($filter_custom_fields)
        {
            $query = $this->_db->getQuery(true);
            $query->select('`custom_title`');
            $query->select('`virtuemart_custom_id`');
            $query->from('#__virtuemart_customs');
            $query->where('`virtuemart_custom_id` IN ('.implode(', ',$filter_custom_fields).')');
            $this->_db->setQuery((string)$query);
            return $this->_db->loadAssocList();
            
        }

        /**
	 * Method to export CSV data from table virtuemart_product_custom_plg_param
	 *
	 * @param	array of id exported rows
	 * @return	bool and error string.
	 * @since	0.0.1
         * @author	Konstantin Ovcharenko
	 */
        function export_csv()
        {
            $filter_custom_fields = JRequest::getVar('filter_custom_fields');
            $a_custom_fields = $this->_build_a_custom_fields($filter_custom_fields);
            $data = array();
            $k=0;
            for($i=0; $i<count($a_custom_fields);$i++ )
            {
                $custom_field = $a_custom_fields[$i];
                $query = &$this->_buils_export_query($custom_field);
                $this->_db->setQuery((string)$query);
                $rows = $this->_db->loadAssocList();
                foreach ($rows as $row)
                {
                    $data[$k]['virtuemart_custom_id'] = $row['virtuemart_custom_id'];
                    $data[$k]['virtuemart_product_id'] = $row['virtuemart_product_id'];
                    $data[$k]['product_name'] = iconv("utf-8", "windows-1251",$row['product_name']);
                    $data[$k]['intvalue'] = iconv("utf-8", "windows-1251",str_replace('.', ',', $row['intvalue']));
                    $data[$k]['custom_title'] = iconv("utf-8", "windows-1251",$row['custom_title']);
                    $k++;
                }
            }
            $name = 'com_condpower.csv';
            $path = JPATH_ROOT.DS.'tmp'.DS.$name;
            if ($fp = fopen($path, "w+"))
            {
                foreach ($data as $fields) {
                    fputcsv($fp, $fields, ';', '"');
                }
                fclose($fp);
            }
            else
            {
                return array(FALSE, JTEXT::_('COM_CONDPOWER_ERROR_OPEN_TO_EXPORT'));
            }
//            $href = str_replace('administrator/', '', JURI::base()).'tmp/'.$name;
//            $href = JURI::base().'components/com_condpower/download.php?path='.$path;
            return array(TRUE,'OK');

        }
	/**
	 * Method to import CSV data from table virtuemart_product_custom_plg_param
	 *
	 * @param	noting
	 * @return	bool and error string.
	 * @since	0.0.1
         * @author	Konstantin Ovcharenko
	 */

        function import_csv()
        {
            $msg = 'OK';
            $path = JPATH_ROOT.DS.'tmp'.DS.'com_condpower.csv';
            if (!$this->_get_file_import($path))
            {
                return array(FALSE, JTEXT::_('COM_CONDPOWER_ERROR_UPLOAD_IMPORT_CSV_FILE'));
            }
//            $_data = array();  
            if ($fp = fopen($path, "r"))
            {
                while (($data = fgetcsv($fp, 1000, ';', '"')) !== FALSE) 
                {
                    unset($_data);
                    $_data['virtuemart_custom_id'] = $data[0];
                    $_data['virtuemart_product_id'] = $data[1];
                    $id = $this->_find_id($_data['virtuemart_custom_id'],$_data['virtuemart_product_id']);
                    if((int)$id>0)
                    {
                        $_data['id'] = $id;
                    }
//                    $_data['intvalue'] = iconv('windows-1251','utf-8',$data[3]);
                    $_data['intvalue'] = str_replace(',', '.', iconv('windows-1251','utf-8',$data[3]));
                    if(!$this->_save($_data))
                    {
                        $msg = 'ERROR';
                    }
                }
                fclose($fp);
            }
            else
            {
                return array(FALSE, JTEXT::_('COM_CONDPOWER_ERROR_OPEN_TO_IMPORT'));
            }
            return array(TRUE,$msg);
        }
	/**
	 * Method to load CSV file from $_FILE variable
	 *
	 * @param	string - path to dest
	 * @return	bool
	 * @since	0.0.1
         * @author	Konstantin Ovcharenko
	 */
        private function _get_file_import($tmp_dest)
        {
            $jFileInput = new JInput($_FILES);
            $theFile = $jFileInput->get('file_upload',array(),'array');


            // If there is no uploaded file, we have a problem...
            if (!is_array($theFile)) {
                JError::raiseWarning('', 'No file was selected.');
                return false;
            }
            // Build the paths for our file to move to the components 'upload' directory
            $tmp_src    = $theFile['tmp_name'];

            // Move uploaded file
            jimport('joomla.filesystem.file');
            return JFile::upload($tmp_src, $tmp_dest);
        }
	/**
	 * Method to import CSV data from table virtuemart_product_custom_plg_param
	 *
	 * @param	noting
	 * @return	bool and error string.
	 * @since	0.0.1
         * @author	Konstantin Ovcharenko
	 */
        private function _find_id($virtuemart_custom_id, $virtuemart_product_id)
        {
            $query = $this->_db->getQuery(true);
            $query->select('id');
            $query->from('#__virtuemart_product_custom_plg_param');
            $query->where('virtuemart_custom_id ='.$virtuemart_custom_id);
            $query->where('virtuemart_product_id ='.$virtuemart_product_id);
            $this->_db->setQuery((string)$query);
            return $this->_db->loadResult();
        }
}
