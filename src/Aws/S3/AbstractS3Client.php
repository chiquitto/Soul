<?php

namespace Chiquitto\Soul\Aws\S3;

use Aws\S3\S3Client;
use Chiquitto\Soul\Underscore\Arrays;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractS3Client extends S3Client
{

    protected $bucketName;
    
    /**
     * Template value:
     * array(
     *   'service' => 's3',
     *   'region' => 'us-east-1',
     *   'version' => 'latest',
     *   'signature_version' => 'v4',
     *   'credentials' => array(
     *     'key' => 'KEY',
     *     'secret' => 'SECRET'
     *   )
     * );
     *
     * @var array
     */
    protected $options;

    public function __construct(array $args)
    {
        $this->options['exception_class'] = 'Aws\S3\Exception\S3Exception';
        parent::__construct($this->options);
    }

    public function deleteObjectsFacade(array $objects) {
        if (!$objects) {
            return true;
        }

        $objects = Arrays::each($objects, function($v) {
                    return ['Key' => $v];
                });
                
        return parent::deleteObjects([
                    'Bucket' => $this->bucketName,
                    'Delete' => [
                        'Objects' => $objects
                    ]
        ]);
    }

    /**
     * 
     * @return string
     */
    public function getBucket()
    {
        return $this->bucketName;
    }

    /**
     * 
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    protected function putObjectFacade($key, $body, $args = []) {
        return parent::putObject($args + [
                    'Bucket' => $this->bucketName,
                    'Key' => $key,
                    'Body' => $body,
        ]);
    }

}
