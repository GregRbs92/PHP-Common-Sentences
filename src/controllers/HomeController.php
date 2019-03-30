<?php

declare(strict_types=1);

namespace Controllers;

class HomeController
{
    public function compute($request)
    {
        // Check that both file paths are defined
        if (empty($request['firstFile']) || empty($request['secondFile'])) {
            throw new \Exception("At least one file path is missing");
        }
        // Init the variables that will contain the sentences of the files with a counter
        // for each sentence
        $sentences = [];
        // Open the first file and read it line by line
        $firstFile = fopen($request['firstFile'], "r");
        while (!feof($firstFile)) {
            $line = fgets($firstFile);
            if ($line) {
                $this->splitText($line, $sentences, false);
            }
        }
        fclose($firstFile);
        // Open the second file and read it line by line
        $secondFile = fopen($request['secondFile'], "r");
        while (!feof($secondFile)) {
            $line = fgets($secondFile);
            if ($line) {
                $this->splitText($line, $sentences, true);
            }
        }
        fclose($secondFile);
        // Get the sentences whose counter is higher than 1
        $result = [];
        foreach ($sentences as $sentence => $occurences) {
            if ($occurences > 1) {
                $result[] = $sentence;
            }
        }

        return json_encode($result);
    }

    private function splitText($line, &$sentences, $isSecondFile)
    {
        $buffer = '';
        $lineLength = strlen($line);

        for ($i = 0; $i < $lineLength; $i++) {
            // If linebreak and buffer not empty, save sentence then continue
            if ($line[$i] === "\n") {
                if (!empty($buffer)) {
                    $this->addKey($buffer, $sentences, $isSecondFile);
                }
                continue;
            }
            // Append char to buffer
            $buffer = $buffer . $line[$i];
            $isEOL = $i === $lineLength - 1;
            // If end of line, save buffer
            if ($isEOL) {
                $this->addKey($buffer, $sentences, $isSecondFile);
                $buffer = '';
            }
            // If we detect the end of a sentence, save buffer
            else if (in_array($line[$i], ['?', '.', '!']) && $line[$i + 1] === ' ' && preg_match('/[A-Z]+/', $line[$i + 2])) {
                $this->addKey($buffer, $sentences, $isSecondFile);
                $buffer = '';
                $i++;
            }
        }
    }

    private function addKey($key, &$array, $isSecondFile)
    {
        if (isset($array[$key]) && $isSecondFile) {
            $array[$key]++;
        }
        else if (!$isSecondFile) {
            $array[$key] = 1;
        }
    }
}