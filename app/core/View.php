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

    public function setController($controller): void
    {
        $this->controller = $controller;
    }

    public function render($templateName, $data): void
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

        echo $output;
    }

    private function compileTemplate($templateContent, $data): array|string|null
    {
        // Remove comments
        $templateContent = preg_replace('/{#\s*(.*?)\s*#}/s', '', $templateContent);

        // Template inheritance
        $templateContent = preg_replace_callback('/{%\s*extends\s+(.*?)\s*%}/', function ($matches) use ($templateContent, $data) {
            $parentTemplate = $matches[1];
            $parentContent = file_get_contents($this->templateDir . '\\' . $parentTemplate);
            $childContent = str_replace('{% block content %}', $templateContent, $parentContent);
            return $this->compileTemplate($childContent, $data);
        }, $templateContent);

        // Loop blocks
        $templateContent = preg_replace_callback('/{%\s*for\s+(\w+)\s+in\s+([\w\.]+)\s*%}(.*?)\s*{%\s*endfor\s*%}/s', function ($matches) use ($data) {
            $loopVariable = $matches[1];
            $arrayVariable = $matches[2];
            $loopContent = $matches[3];

            $output = '';
            $array = $data[$arrayVariable] ?? [];

            foreach ($array as $item) {
                $data[$loopVariable] = $item;
                $output .= $this->compileTemplate($loopContent, $data);
            }

            return $output;
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

        // Functions in variables
        $templateContent = preg_replace_callback('/{{\s*([\w\.]+)\((.*)\)\s*}}/', function ($matches) use ($data) {
            $functionName = $matches[1];
            $arguments = $matches[2];
            $variablePath = explode('.', $arguments);
            $value = $data;

            foreach ($variablePath as $key) {
                if(is_object($value)){
                    $value = isset($value->$key) ? $value->$key : '';
                } else {
                    $value = isset($value[$key]) ? $value[$key] : '';
                }

            }

            if (method_exists($this->controller, $functionName)) {
                // Call the function dynamically on the controller instance
                $value = call_user_func([$this->controller, $functionName], $value);
            }

            return $value;
        }, $templateContent);

        // Variable placeholders
        $templateContent = preg_replace_callback('/{{\s*([\w\.]+)\s*}}/', function ($matches) use ($data) {
            $variablePath = explode('.', $matches[1]);
            $value = $data;

            foreach ($variablePath as $key) {
                if(is_object($value)){
                    $value = isset($value->$key) ? $value->$key : '';
                } else {
                    $value = isset($value[$key]) ? $value[$key] : '';
                }
            }

            return htmlspecialchars($value);
        }, $templateContent);

        return $templateContent;
    }

    private function evaluateCondition($condition, $data) {
        $condition = trim($condition);
        $pattern = '/(\w+)\((.*)\)/';
        $matches = [];

        $value = $data;

        if (preg_match($pattern, $condition, $matches)) {
            $methodName = $matches[1];
            $arguments = $matches[2];
            $variablePath = explode('.', $arguments);

            foreach ($variablePath as $key) {
                $value = is_object($key) ? ($value->$key ?? '') : ($value[$key] ?? '');
            }

            if (method_exists($this->controller, $methodName)) {
                $value = call_user_func([$this->controller, $methodName], $value);
            }

            return $value;
        }

        if (str_contains($condition, '==')) {
            [$left, $right] = explode('==', $condition);
            $valueLeft = $this->getStringValue($left) ?: $this->getValueFromVariablePath($value, $left);
            $valueRight = $this->getStringValue($right) ?: $this->getValueFromVariablePath($value, $right);
            return $valueLeft == $valueRight;
        } elseif (str_contains($condition, '!=')) {
            [$left, $right] = explode('!=', $condition);
            $valueLeft = $this->getStringValue($left) ?: $this->getValueFromVariablePath($value, $left);
            $valueRight = $this->getStringValue($right) ?: $this->getValueFromVariablePath($value, $right);
            return $valueLeft != $valueRight;
        }

        return eval("return $condition;");
    }

    private function getStringValue($string)
    {
        if (preg_match("/'([^']+)'/", $string, $matches)) {
            return $matches[1];
        }
        return false;
    }

    private function getValueFromVariablePath($value, $path) {
        $variablePath = explode('.', trim($path));

        foreach ($variablePath as $key) {
            $value = is_object($value) ? ($value->$key ?? '') : ($value[$key] ?? '');
        }

        return $value;
    }


}

