<?php

return [
	/**
     * The URL of the BW
     */
    'api-url'=> env('SES_API_URL',''),

	/**
     * The Applications token - Required to make authorised requests to the API
     */
    'application-token'=> env('SES_APPLICATION_TOKEN','')

];
