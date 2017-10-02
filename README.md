# youtube2mp3 - API to convert videos from YouTube and get download url

## Basic Usage

Usage is pretty straight forward:

```
GET /api/youtube2mp3/?url=https://www.youtube.com/watch?v=fJ9rUzIMcZQ
```

Response body:

```
{
    "videoId": "fJ9rUzIMcZQ",
    "downloadUrl": "http://2017100207.youtube6download.top/cnvx.php?id=fJ9rUzIMcZQ"
}
```

## Prerequisites
- Please make sure you have curl installed and enabled on your server