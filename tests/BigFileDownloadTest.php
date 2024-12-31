<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/20
 * Time: 11:36 下午.
 */

namespace HughCube\GuzzleHttp\Tests;

use GuzzleHttp\RequestOptions;
use HughCube\GuzzleHttp\Client;

class BigFileDownloadTest extends TestCase
{
    public function testDownload()
    {
        $client = new Client();

        $file = sprintf('%s/BigFileDownloadTest-%s', sys_get_temp_dir(), microtime(true));
        $url = 'http://datax-opensource.oss-cn-hangzhou.aliyuncs.com/datax.tar.gz';

        $minFileSize = 10;
        //ini_set('memory_limit', sprintf('%sm', $minFileSize));
        try {
            $response = $client->getLazy($url, [
                RequestOptions::SINK => $file
            ]);

            $this->assertSame(200, $response->getStatusCode());
            $this->assertLessThan(10 * 1024 * 1024, memory_get_peak_usage());
            $this->assertGreaterThan($minFileSize * 1024 * 1024, filesize($file));
            $this->assertSame(md5_file($file), '8e93697addbd26bebc157613089a1173');
        } finally {
            @unlink($file);
        }
    }
}
