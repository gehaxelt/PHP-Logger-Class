<?php

namespace gehaxelt\fileLogger {
    
    /**
     * Package info
     * 
     * About this package.
     */
    class PackageInfo {
        
        protected static $packageInfo = array(
            'version' => 1.2,
            
            'authors' => array(
                'gehaxelt' => array(
                    'github' => 'https://github.com/gehaxelt/',
                    'email' => 'github@gehaxelt.in',
                    'site' => 'http://www.gehaxelt.in'
                ),
                
                'pedzed' => array(
                    'github' => 'https://github.com/pedzed/'
                )
            )
        );
        
        public static function getInfo(){
            return self::$packageInfo;
        }
        
    }
    
}
