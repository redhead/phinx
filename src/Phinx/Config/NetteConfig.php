<?php

class Config extends \Phinx\Config\Config {

    protected $container;


    public function __construct(\Nette\DI\Container $container) {
        $this->container = $container;
    }


    public static function fromContainer(\Nette\DI\Container $container) {
        $container->getByType('Environment');
        return new Config($container);
    }


    public function getDefaultEnvironment() {
        return $this->container->parameters['environment'];
    }


    public function getEnvironment($name) {
        $params = $this->container->parameters['database'];
        return array(
            'adapter' => $params['driver'],
            'host' => $params['host'],
            'name' => $params['dbname'],
            'user' => $params['user'],
            'pass' => $params['password'],
            'port' => isset($params['port']) ? $params['port'] : 3306
        );
    }


    public function getEnvironments() {
        throw new \Nette\NotSupportedException();
    }


    public function getConfigFilePath() {
        throw new \Nette\NotSupportedException();
    }


    public function getMigrationPath() {
        return $this->container->parameters['database']['migrations'];
    }


    public function hasEnvironment($name) {
        return true;
    }


    public function replaceTokens($str) {
        return $str;
    }

}