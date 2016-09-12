<?php

namespace LaraPress\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

abstract class AdminPageController extends Controller {

    /**
     * The text to be displayed in the title tags of the page when the menu is selected.
     *
     * @var string
     */
    protected $title;

    /**
     * The on-screen name text for the menu
     *
     * @var string
     */
    protected $menuTitle;

    /**
     * The slug name for the parent menu, or the file name of a standard
     * WordPress admin file that supplies the top-level menu
     *
     * @var string
     */
    protected $parentSlug;

    /**
     * The url to the icon to be used for this menu. This parameter is optional
     *
     * @var string
     */
    protected $icon;

    /**
     * The position in the menu order this menu should appear.
     *
     * @var int
     */
    protected $position;

    /**
     * The capability required for this menu to be displayed to the user.
     * When using the Settings API to handle your form, you should use
     * 'manage_options' here as the user won't be able to save options without it.
     *
     * @var array
     */
    protected $capability = 'manage_options';

    public function _render()
    {
        $response = $this->render();

        echo $response;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getMenuTitle()
    {
        return $this->menuTitle;
    }

    /**
     * @return string
     */
    public function getParentSlug()
    {
        return $this->parentSlug;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return array
     */
    public function getCapability()
    {
        return $this->capability;
    }
}
