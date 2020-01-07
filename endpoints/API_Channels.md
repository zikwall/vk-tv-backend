# Get all channels

**URL** : `/vktv/api/channels/`

**URL Parameters** : 
- `useHttp=[integer][0..1]`, where `useHttp` the unsafe link return, flag is `0` by default.
- `withGrouped=[integer][0..1]`, where `withGrouped` grouped data return flag or not, flag is `1` by default.

**Method** : `GET`

**Auth required** : NO

**Permissions required** : NO

**Data**: `{}`

## Success Response

**Condition** : NO.

**Code** : `200 OK`

**Content example**

Options: `withGrouped=1`

```json
[
    {
        "title": "Кино и фильмы",
        "data": [
            {
                "epg_id": "140015",
                "name": "Kronehit HD",
                "url": "https://bitcdn-kronehit.bitmovin.com/v2/hls/chunklist_b1628000.m3u8",
                "image": null,
                "use_origin": "0",
                "xmltv_id": null
            }
        ]
    }
]
```

Options: `withGrouped=0`

```json
[
    {
        "epg_id": "16",
        "name": "Россия 1 (Кабардино-Балкария)",
        "url": "https://83tpjqlujs1.a.trbcdn.net/livemaster/tftrm1v2h9_stream1/playlist.m3u8",
        "image": "http://tv.zikwall.ru/images/logo/Россия 1.png",
        "use_origin": "0",
        "xmltv_id": null,
        "categoty": "Новостные"
    }
]
```

## Error Responses

**Condition** : NO.

**Code** : `404 NOT FOUND`

**Content** : `{}`

### Or

**Condition** : NO

**Code** : `403 FORBIDDEN`

**Content** :

```json
{"detail": "You do not have permission to perform this action."}
```

## Notes

There are security issues:

* Channel identifiers are sequential, so the user can read all the channels in the system.
