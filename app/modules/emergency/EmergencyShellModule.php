<?php

Kurogo::includePackage('Emergency');

class EmergencyShellModule extends ShellModule {

    protected $id='emergency';
    
    public function getAllControllers() {
        $controllers = array();
        
        $config = $this->loadFeedData();
        if(isset($config['contacts'])) {
            try {
                if (isset($config['contacts']['CONTROLLER_CLASS'])) {
                    $modelClass = $config['contacts']['CONTROLLER_CLASS'];
                } else {
                    $modelClass = isset($config['contacts']['MODEL_CLASS']) ? $config['contacts']['MODEL_CLASS'] : 'EmergencyContactsDataModel';
                }
                
                $controllers[] = EmergencyContactsDataModel::factory($modelClass, $config['contacts']);
            } catch (KurogoException $e) { 
                $controllers[] = DataController::factory($config['contacts']['CONTROLLER_CLASS'], $config['contacts']);
            }
            
        }
        
        if(isset($config['notice'])) {
            try {
                if (isset($config['notice']['CONTROLLER_CLASS'])) {
                    $modelClass = $config['notice']['CONTROLLER_CLASS'];
                } else {
                    $modelClass = isset($config['notice']['MODEL_CLASS']) ? $config['notice']['MODEL_CLASS'] : 'EmergencyNoticeDataModel';
                }
            
                $controllers[] = EmergencyNoticeDataModel::factory($modelClass, $config['notice']);
            } catch (KurogoException $e) { 
                $controllers[] = DataController::factory($config['notice']['CONTROLLER_CLASS'], $config['notice']);
            }
        }
        
        return $controllers;
    }
    
    protected function initializeForCommand() {
    
        switch($this->command) {
            case 'fetchAllData':
                $this->preFetchAllData();
                
                return 0;
                
                break;
            default:
                $this->invalidCommand();
                break;
        }
    }
}