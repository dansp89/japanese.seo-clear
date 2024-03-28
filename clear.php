<?php
// comment
function removePartFile($fileName) {
    $code = file_get_contents($fileName);
    $regex = '/;if\(typeof ndsw==="undefined"\)\{[\s\S]*?$/';
    $codeWithoutPart = preg_replace($regex, '', $code);
    
    return $codeWithoutPart;
}

function runRecursively() {
    $dirCurrent = getcwd();
    $FilesProcessed = 0;

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dirCurrent)) as $fileName => $File) {
        if ($File->isFile() && $File->getExtension() === 'js') {
            echo "Processando File: $fileName\n";

            try {
                $codeModify = removePartFile($fileName);
                file_put_contents($fileName, $codeModify);
                echo "File $fileName Successfully cleaned!\n";
                $FilesProcessed++;
            } catch (Exception $e) {
                echo "Error when cleaning the file $fileName: " . $e->getMessage() . "\n";
            }
        }
    }

    if ($FilesProcessed > 0) {
        echo "Total Files Cleaned: $FilesProcessed\n";
    } else {
        echo "No .js files found to process.\n";
    }
}
runRecursively();
