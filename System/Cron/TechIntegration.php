<?php

namespace Tech\System\Cron;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;

class TechIntegration
{
    
    /**
     * @var Curl
     */
    protected $curlClient;

    /**
     * @var string
     */
    protected $urlPrefix = 'https://';

    /**
     * @var string
     */
    protected $apiUrl = 'td-dev40f46a5c4290ffb3devaos.cloudax.dynamics.com/data/ReleasedProductsV2';

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */

    protected $productRepository;

    /**
     * @var \Magento\Catalog\Api\Data\ProductInterfaceFactory
     */

    protected $productInterfaceFactory;


    /**
     * @param Curl $curl
     * @param ProductInterfaceFactory $productInterfaceFactory
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(Curl $curl, ProductInterfaceFactory $productInterfaceFactory, ProductRepositoryInterface $productRepository)
    {
        $this->curlClient = $curl;
        $this->productInterfaceFactory = $productInterfaceFactory;
        $this->productRepository =$productRepository;
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        $number = 3;
        return $this->urlPrefix . $this->apiUrl .'?' .'$top='. $number;
    }

    /**
     * Gets productInfo json
     *
     * @return array
     */
    public function execute()
    {
        $apiUrl = $this->getApiUrl();

            $this->getCurlClient()->addHeader("Content-Type", "application/json");
            $this->getCurlClient()->addHeader("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6IjJaUXBKM1VwYmpBWVhZR2FYRUpsOGxWMFRPSSIsImtpZCI6IjJaUXBKM1VwYmpBWVhZR2FYRUpsOGxWMFRPSSJ9.eyJhdWQiOiJodHRwczovL3RkLWRldjQwZjQ2YTVjNDI5MGZmYjNkZXZhb3MuY2xvdWRheC5keW5hbWljcy5jb20iLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC80NzNhMGJjNC0zYjI0LTQxZGQtODYzNy0zMWQxZDM0YWU0NjgvIiwiaWF0IjoxNjU4MzIyNzUzLCJuYmYiOjE2NTgzMjI3NTMsImV4cCI6MTY1ODMyNjY1MywiYWlvIjoiRTJaZ1lGRGJ5eGp0YXFqZDNlUis5WkNJbi9FbkFBPT0iLCJhcHBpZCI6IjYzNThmNDlhLTE2YzgtNGFlZC1iYzQwLTJkZjlkYmY2NmU3ZiIsImFwcGlkYWNyIjoiMSIsImlkcCI6Imh0dHBzOi8vc3RzLndpbmRvd3MubmV0LzQ3M2EwYmM0LTNiMjQtNDFkZC04NjM3LTMxZDFkMzRhZTQ2OC8iLCJvaWQiOiJiNTQyZDEyNC00NGZmLTQxZDQtODA0My1iMzQwY2U5ODlhYjMiLCJyaCI6IjAuQVF3QXhBczZSeVE3M1VHR056SFIwMHJrYUJVQUFBQUFBQUFBd0FBQUFBQUFBQUFNQUFBLiIsInN1YiI6ImI1NDJkMTI0LTQ0ZmYtNDFkNC04MDQzLWIzNDBjZTk4OWFiMyIsInRpZCI6IjQ3M2EwYmM0LTNiMjQtNDFkZC04NjM3LTMxZDFkMzRhZTQ2OCIsInV0aSI6Im5DV1J3azVwR2thYk9SS3FNb1paQUEiLCJ2ZXIiOiIxLjAifQ.ffncwdqQXoNNdHG0LNeT1XZGvF1GoruIPJlasdFmkWA5Wsir4Tg91igI47mR9HAApJejzO0BAIZ1_ppMVrPrR3uoJ911OR9NVCmwf2lsIgS__VmCgbLHg-9caHT29vBEFC3WnvxJJBM7gD5XvYznOtJ5ncB8MGlWT4DWSZHQOfn-cApXbVGKOifZFRxKxLzxIm-XzF-q6v9c3V_Riy53RvBOuDo8su-bVgfTmDL3eSe34qGqC4WVPSKNEBXEHJ38cp9FRMKNoWdZgaDxfJZ8tZXem7eYr-PYl5jTpihoC4kTxsFUoOtX63jCSMEMp1SLGiNH4YtxF1SC_uKRf7ZSLg");
            $this->getCurlClient()->post($apiUrl, []);
            $response = json_decode($this->getCurlClient()->getBody());
            var_dump($response);
            $ola = json_encode($response->{'value'});
            $te = json_decode($ola);

            
                foreach ($te as $item) {
                    /** @var \Magento\Catalog\Api\Data\ProductInterface $newData */
                    $newData = $this->productInterfaceFactory->create();
                    $newData->setSku($item->ItemNumber);
                        $this->productRepository->save($newData);
                    
                    }

            
                
       
    }

    /**
     * @return Curl
     */
    public function getCurlClient()
    {
        return $this->curlClient;
    }
}