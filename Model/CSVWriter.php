<?php

namespace Eermolaev\Challenge\Model;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Phrase;

/**
 * Class CSVWriter
 * @package Eermolaev\Challenge\Model
 */
class CSVWriter extends File
{
    /** @var */
    protected $resource;

    /**
     * @param $data
     * @throws FileSystemException
     */
    public function outputAsCsv($data)
    {
        /** enable unicode support */
        fwrite($this->getResource(), "\xEF\xBB\xBF");

        $this->filePutCsv(
            $this->getResource(),
            $data
        );
    }

    /**
     * @return resource
     * @throws FileSystemException
     */
    protected function getResource()
    {
        if (!$this->resource) {
            $this->resource = $this->fileOpen('php://output', 'w+');
        }

        return $this->resource;
    }

    /**
     * Writes one CSV row to the file.
     *
     * @param resource $resource
     * @param array $data
     * @param string $delimiter
     * @param string $enclosure
     * @return int
     * @throws FileSystemException
     */
    public function filePutCsv($resource, array $data, $delimiter = ',', $enclosure = '"')
    {
        $hasHeader = true;
        foreach ($data as $key => $value) {
            if (!is_string($key)) {
                $hasHeader = false;
            }
        }

        if ($hasHeader) {
            $this->filePutCsv($resource, array_keys($data));
        }

        /**
         * Security enhancement for CSV data processing by Excel-like applications.
         * @see https://bugzilla.mozilla.org/show_bug.cgi?id=1054702
         *
         * @var $value string|Phrase
         */
        foreach ($data as $key => $value) {
            if (!is_string($value)) {
                $value = (string)$value;
            }
            $value = str_replace($enclosure, '\\' . $enclosure, $value);
            if (isset($value[0]) && in_array($value[0], ['=', '+', '-'])) {
                $data[$key] = ' ' . $value;
            }
        }

        $result = @fputcsv($resource, $data, $delimiter, $enclosure);
        if (!$result) {
            throw new FileSystemException(
                new Phrase(
                    'An error occurred during "%1" filePutCsv execution.',
                    [$this->getWarningMessage()]
                )
            );
        }
        return $result;
    }
}