# brian


To access the respective API, assume the host is always the same:

`http://ec2-54-66-246-123.ap-southeast-2.compute.amazonaws.com/brian/src/public/`


## Client

| METHOD | API | Description |
| --- | --- | --- |
| GET | `/client` | List of *all* offenders |
| GET | `/client/{id}` | Detailed information about offender |
| GET | `/client/{id}/messages` | List all correspondence |
| GET | `/client/{id}/communitywork` | List of *all* assigned community work |
| GET | `/client/{id}/location` | List of *all* assigned locations |
| GET | `/client/{id}/staff` | List of *all* assigned staff |
| GET | `/client/{id}/phone` | List of *all* offender's phone numbers |

## Staff

| METHOD | API | Description |
| --- | --- | --- |
| GET | `/staff` | List of *all* authenticated staff |
| GET | `/staff/location/{id}` | List of *all* authenticated staff from a location |
| GET | `/staff/{username}/client` | List all offenders assigned to CM |
| GET | `/staff/{username}/client/location/{id}` | List offenders assigned to CM in a location (//TODO) |

## Users

| METHOD | API | Description |
| --- | --- | --- |
| GET | `/user` | List of *all* users |
| GET | `/user/{id}` | Detailed information about user (role only?) |
| POST | `/user/{id}/assign/{role}` | Assigns a user a specific role (//TODO) |
| GET | `/user/type` | List of *all* user types |
| GET | `/user/type/{role}` | List *all* users with a specific role |
| GET | `/user/location/{id}` | List *all* users from a location |
| GET | `/user/location/{id}/type/{role}` | List *specific* users from a location |
| GET | `/user/location/{id}/authenticate` | List users that need to be authenticated in a location |
| GET | `/user/authenticate` | List *all* users that require authentication |
| POST | `/user/authenticate/{username}` | Authenticates a specific user (//TODO) |
| GET | `/user/region/{id}` | List *all* users from a region (//TODO) |
| GET | `/user/region/{id}/type/{role}` | List *specific* users from a region (//TODO) |


## Location

| METHOD | API | Description |
| --- | --- | --- |
| GET | `/location` | List of *all* locations |
| GET | `/location/detail` | List of *all* locations, with detail |
| GET | `/location/{id}` | *One* location, with detail |
| GET | `/location/region/{id}` | List of *all* locations within a region |
| GET | `/location/region/{id}/detail` | List of *all* locations within a region, with detail |


## Region

| METHOD | API | Description |
| --- | --- | --- |
| GET | `/region` | List of *all* regions |
| GET | `/region/{id}` | List of *all* locations, within a region (same as `/location/region/{id}`) |


## Area

| METHOD | API | Description |
| --- | --- | --- |
| GET | `/area` | List of *all* areas |