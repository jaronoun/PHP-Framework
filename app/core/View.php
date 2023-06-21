<?php

namespace Isoros\core;

use Exception;

class View
{
    protected $view;
    protected array $data = [];

    private $templateDir;
    private $controller;

    public function __construct($templateDir) {
        $this->templateDir = $templateDir;
    }

    public function setController($cotroller)
    {
        $this->controller = $cotroller;
    }

    public function render($templateName, $data): bool|string
    {
        $templatePath = $this->templateDir . '\\' . $templateName;

        if (!file_exists($templatePath)) {
            throw new Exception("Template file not found: " . $templatePath);
        }

        $templateContent = file_get_contents($templatePath);
        $compiledContent = $this->compileTemplate($templateContent, $data);

        // Execute the compiled PHP code
        ob_start();
        eval(' ?>' . $compiledContent . '<?php ');
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    private function compileTemplate($templateContent, $data) {
        // Remove comments
        $templateContent = preg_replace('/{#\s*(.*?)\s*#}/s', '', $templateContent);

        // Template inheritance
        $templateContent = preg_replace_callback('/{%\s*extends\s+(.*?)\s*%}/', function ($matches) use ($templateContent, $data) {
            $parentTemplate = $matches[1];
            $parentContent = file_get_contents($this->templateDir . '\\' . $parentTemplate);
            $childContent = str_replace('{% block content %}', $templateContent, $parentContent);
            return $this->compileTemplate($childContent, $data);
        }, $templateContent);

        // Conditional blocks
        $templateContent = preg_replace_callback('/{%\s*if\s+(.*?)\s*%}(.*?)(?:{%\s*else\s*%}(.*?))?{%\s*endif\s*%}/s', function ($matches) use ($data) {
            if (!isset($data[$matches[1]])) {
                $condition = $matches[1];
            } else {
                $condition = $data[$matches[1]];
            }
            $ifContent = $matches[2];
            $elseContent = $matches[3] ?? '';

            $output = '';
            if ($this->evaluateCondition($condition, $data)) {
                $output = $this->compileTemplate($ifContent, $data);
            } else {
                $output = $this->compileTemplate($elseContent, $data);
            }

            return $output;
        }, $templateContent);

        // Loop blocks
        $templateContent = preg_replace_callback('/{%\s*for\s+(\w+)\s+in\s+([\w\.]+)\s*%}(.*?)\s*{%\s*endfor\s*%}/s', function ($matches) use ($data) {
            $loopVariable = $matches[1];
            $arrayVariable = $matches[2];
            $loopContent = $matches[3];

            $output = '';
            $array = $data[$arrayVariable] ?? [];

            foreach ($array as $exam) {
                foreach ($exam as $item) {
                    $data[$loopVariable] = $item;
                }
                $output .= $this->compileTemplate($loopContent, $data);
            }

            return $output;
        }, $templateContent);

        // Variable placeholders
        $templateContent = preg_replace_callback('/{{\s*([\w\.]+)\s*}}/', function ($matches) use ($data) {

            $variablePath = explode('.', $matches[1]);
            $value = $data;

//            var_dump($value);

            foreach ($variablePath as $key) {
                $value = isset($value[$key]) ? $value[$key] : '';
            }

            return $value;
        }, $templateContent);

        // Functions in variables
        $templateContent = preg_replace_callback('/{{\s*([\w\.]+)\((.*)\)\s*}}/', function ($matches) use ($data) {
            $functionName = $matches[1];
            $arguments = $matches[2];
            $variablePath = explode('.', $arguments);
            $value = $data;

            foreach ($variablePath as $key) {
                $value = isset($value[$key]) ? $value[$key] : '';
            }

            if (method_exists($this->controller, $functionName)) {
                // Call the function dynamically on the controller instance
                $value = call_user_func([$this->controller, $functionName], $value);
            }

            return $value;
        }, $templateContent);


        return $templateContent;
    }

    private function evaluateCondition($condition, $data) {

        // Remove leading/trailing whitespaces from the condition
        $condition = trim($condition);

        // Check for specific comparison operators
        if (str_contains($condition, '==')) {
            [$left, $right] = explode('==', $condition);
            return $data[trim($left)] == trim($right);
        } elseif (str_contains($condition, '!=')) {
            [$left, $right] = explode('!=', $condition);
            return trim($data[$left]) != trim($data[$right]);
        }

        // Default case: evaluate the condition as a truthy/falsy expression
        return eval("return $condition;");
    }


}

