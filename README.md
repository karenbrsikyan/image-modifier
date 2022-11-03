# image-modifier

================

PHP service to resize and crop images.

------------------

# Requirements
The Image Modifier service has the following requirements:
- PHP 8.1+
- GD Library

# Service description

The image service can deliver images using a GET request which are stored on the server.
It is possible to use different modifiers to change what will be returned.
Two modifiers are implemented:
1. crop-modifier (will cut the image and will take height and width as parameters)
2. resize-modifier (resizes the images based on given height and width as parameters)

Further modifiers are ready to integrate easily in the code.

After you access an image you will be redirected to a beautified url (without modification parameters).

The service outputs images in the same file format (e.g. jpg) as they have been read.

# Example of image service usage

The original images should be stored in the following folder to be accessible by the service:
``` projectRoot/storage/original/images ```.

Let's say we want to retrieve image "screen.png" in the size of 150px height and 250px width.
The original image on the server has the following dimensions: 681px height, 584px width.

We trigger retrieving the image by using an url like:
``` http://localhost:8000/screen.png/resize/250/150 ```

We will get redirected to: 
   http://localhost:8000/<generated-image-name\>.png
   
Note: The service uses the GD library which currently do not support modification of the animated gif files.

------------------

# Installation

1. Clone GIT repository:
    ```bash
    $ git clone git@github.com:karenbrsikyan/image-modifier.git
    ```
2. Initialize the docker container. This will download and install all the required dependant images:
    ```bash
    $ cd /path/to/project/docker
    $ docker-compose up -d
    ```
3. Install the composer packages:
    ```bash
    $ cd /path/to/project
    $ composer install 
    $ composer dump-autoload
    ```

Now the project should be accessible in the localhost with the port 8000.
You can verify it by navigating to the following sample page showing an example of cropped and resized images:

[http://localhost:8000/sample-page](http://localhost:8000/sample-page "Navigate to Sample Page")



## Custom tools

You create your own tool or modifier by extending the `\ImageModifier\Tool\AbstractTool` abstract class.
You may register any amount of tools and use them in the same way built-in tools are used.

```php
// Create a new tool which can be accesed as 'flip'
class Flip extends AbstractTool
{
    ...
    
    // make sure to implement the function execute()
}
```

#### Usage:

``` http://localhost:8000/screen.png/flip/someparams ```

<br />
