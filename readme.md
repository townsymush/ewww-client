# Ewww.io Client

This client is a helper for using the ewww.io api for converting images to png, webp and optimising for use on the web.
 
 To use ewww.io you require a api-key. Visit https://ewww.io to make an account
 
 Please note that any functionality for ewww.io is entirely ewww.io's responsibility, this package is just a helper to use their API.
 
 To install this package through composer 
 ```
composer require townsymush/ewww-client
 ```
 
 ## Usage
 
 Create new instance of the converter
 The converter requires your api key as a string and a Guzzle Client to make the API requests
```
use TownsyMush\EwwwClient\Converter;
use GuzzleHttp\Client;

$converter = new Converter(new Client, 'your-api-key');
```

To convert/optimise and image you need to make a `Job` to process. There are two jobs `WebPJob` and `FileJob`

### WebPJob
A `WebPJob` is used to convert an image (png, jpg) to a `webp` file. 

#### Create job
If the file cannot be opened an exception will be thrown.
```
use GuzzleHttp\Client;
use TownsyMush\EwwwClient\Converter;
use TownsyMush\EwwwClient\WebPJob;

$converter = new Converter(new Client, 'your-api-key');

// Create new instance with filename set as 'filename'
$job = new WebPJob('path-to-file', 'filename');
```

#### Set height and width (optional)
If you want to change height and width of image. You must set both on the job. The methods accept an integer which will set the image sizes in pixels
```
$job->setWidth(100);
$job->setHeight(100);
```

#### Set image quality (optional)
If you want to change the quality of the image set the quality with the following method.
note the default is set at 82
```
$job->setQuality(82);
```

### FileJob
This job is used to optimise and image or convert a `jpg` or `gif` to `png`.

#### Create job
If the file cannot be opened an exception will be thrown.
```
use GuzzleHttp\Client;
use TownsyMush\EwwwClient\Converter;
use TownsyMush\EwwwClient\FileJob;

$converter = new Converter(new Client, 'your-api-key');

// Create new instance with filename set as 'filename'
$job = new FileJob('path-to-file', 'filename');
```

#### Set image quality (optional)
If you want to change the quality of the image set the quality with the following method.
note the default is set at 82 and this is only in effect is `convert` is set to `true` when processing `PNG` images.
```
$job->setQuality(82);
```

#### Preserve metadata (optional)
To preserve metadata in the image file set the `metadata` to `true`.
Note: Default is `false`
```
$job->setMetadata(true);
```

#### Lossy compression (optional) (Recommended)
To set lossy compression for higher compression with minimal quality loss
Note: Default is `false`
```
$job->setLossy(true);
```

#### Convert file (optional)
To convert the file type set this to `true`. It enables the conversion mode on the `ewww.io API` request (`JPG` to `PNG`, `PNG` to `JPG` or `GIF` to `PNG`)
```
$job->setConvert(true);
```

### Processing a job example
Once a job has been created, the next step is to process that job with the converter.

```
use GuzzleHttp\Client;
use TownsyMush\EwwwClient\Converter;
use TownsyMush\EwwwClient\FileJob;

$converter = new Converter(new Client, 'your-api-key');

// Create new instance with filename set as 'filename'
$job = new FileJob('path-to-file', 'filename');

$response = $converter->process($job);

// The response object will contain a file response which you can write directly to a resource e.g.
file_put_contents($response, $response)
```

## Worth noting
Unfortunately the ewww.io API does not return error status codes which could make the client throw an exception. 
If the api request failed you will need to inspect the response for the error message.

We are assuming that you will have validated your image before sending it through the ewww.io api. This package does not validate the image types being processed.

## Tests
We have written some tests as part of this package which you can run by running
`./vendor/bin/phpunit` while in the project directory. You will need o add your `api-key` to the tests and remember this will use some of your pre-paid credits on your ewww.io account.
 