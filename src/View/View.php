<?php

namespace OMT\View;

use Exception;

class View
{
    const TEMPLATE = 'Template';
    const MARKUP = 'markup';

    protected $viewTemplate = null;

    /**
     * @param string|string[] $layout Layout name or an array of [template => layout]
     */
    public static function loadTemplate($layout = 'default', array $vars = [])
    {
        return (new static)->render($layout, $vars, self::TEMPLATE);
    }

    /**
     * @param string|string[] $layout Layout name or an array of [template => layout]
     */
    public static function loadMarkup($layout = 'default', array $vars = [])
    {
        return (new static)->render($layout, $vars, self::MARKUP);
    }

    protected function render($layout, array $vars = [], string $type = self::TEMPLATE)
    {
        if ($type === self::TEMPLATE) {
            return $this->templateOutput(
                $this->layoutPath($layout, $type),
                $vars
            );
        }

        if ($type === self::MARKUP) {
            return $this->markupOutput(
                $this->layoutPath($layout, $type),
                $vars
            );
        }
    }

    protected function templateOutput(string $layoutPath, array $vars = [])
    {
        ob_start();

        foreach ($vars as $key => $value) {
            $this->{$key} = $value;
        }

        include $layoutPath;

        return ob_get_clean();
    }

    protected function markupOutput(string $layoutPath, array $vars = [])
    {
        $markup = file_get_contents($layoutPath);

        foreach ($vars as $key => $value) {
            if (is_null($value)) {
                // Delete line from json if variable is null
                $markup = preg_replace('/^.+\${' . $key . '}.+/m', '', $markup, 1);
            } else {
                $markup = str_replace('${' . $key . '}', $value, $markup);
            }
        }

        // Remove trailing comma from the right
        $markup = rtrim(trim(str_replace(['{', '}'], '', $markup)), ',');

        return '<script type="application/ld+json">{' . $markup . '}</script>';
    }

    protected function layoutPath($layout, string $type)
    {
        $layoutFolder = 'Template';
        $layoutExtension = 'php';

        if (is_array($layout)) {
            $viewTemplate = array_key_first($layout);

            $this->viewTemplate = ucfirst($viewTemplate);
            $layout = $layout[$viewTemplate];
        }

        if (is_null($this->viewTemplate) || empty($layout)) {
            throw new Exception('Undefined view or layout');
        }

        if ($type === self::MARKUP) {
            $layoutFolder = 'Markups';
            $layoutExtension = 'json';
        }

        $path = dirname(__DIR__) . '/' . $layoutFolder . '/' . $this->viewTemplate . '/' . $layout . '.' . $layoutExtension;

        if (!is_file($path)) {
            throw new Exception('Layout not found');
        }

        return $path;
    }
}
