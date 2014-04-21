<?php
namespace MyApp;

use \Twig_Extension;

/**
 * Simple extension for Twig which simply takes an array of variables
 * and makes them available in Twig's global namespace.
 */
class TwigExtensionGlobals extends \Twig_Extension
{
    /**
     * An associative array of variables that will be accessible in twig templates
     * @var array
     */
    protected $globals;

    /**
     * Extension constructor
     * 
     * @var array $globals An associative array to be accessible in twig templates
     */
    public function __construct($globals = array()) {
        $this->globals = $globals;
    }

    /**
     * Returns the list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     */
    public function getGlobals() {
        return $this->globals;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'globals';
    }
}