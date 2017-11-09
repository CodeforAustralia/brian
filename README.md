# brian


To access the respective API, assume the host is always the same:

`http://ec2-54-66-246-123.ap-southeast-2.compute.amazonaws.com/brian/src/public/`


## Client

| Method | API | Description |
| --- | --- | --- |
| GET | `/client` | List of *all* offenders |
| GET | `/client/location/{id}` | List of *all* offender's from a location |
| GET | `/client/region/{id}` | List of *all* offender's from a region |
| GET | `/client/{id}` | *All* information about *one* offender |
| GET | `/client/{id}/messages` | List of *all* correspondence for *one* offender |
| GET | `/client/{id}/communitywork` | List of *all* assigned community work for *one* offender |
| GET | `/client/{id}/location` | List of *all* assigned locations for *one* offender |
| GET | `/client/{id}/staff` | List of *all* assigned staff for *one* offender |
| GET | `/client/{id}/phone` | List of *all* offender's phone numbers for *one* offender |

## Staff

| Method | API | Description |
| --- | --- | --- |
| GET | `/staff` | List of *all* authenticated staff |
| GET | `/staff/location/{id}` | List of *all* authenticated staff from a location |
| GET | `/staff/{username}/client` | List of *all* offenders assigned to CM |
| GET | `/staff/{username}/client/location/{id}` | List of offenders assigned to CM from a location |

## Users

| Method | API | Description | Body |
| --- | --- | --- | --- |
| GET | `/user` | List of *all* users | |
| POST | `/user/new` | Create a new user | UserName:{UserName} <br/> Password:{Password} <br/> Role:{Role} <br/> Location:{id} <br/> FirstName:{FirstName} <br/> LastName:{LastName} <br/> Authentication:{Authentication} |
| POST | `/user/password` | Update password (//TODO, not sure what this means yet) | |
| GET | `/user/{username}` | Detailed information about *one* user (role only?) | |
| POST | `/user/{username}` | Assigns a user a *specific role* | `Role:{Role}` |
| GET | `/user/type` | List of *all* user types | |
| GET | `/user/type/{role}` | List of *all* users with a specific role | |
| GET | `/user/location/{id}` | List of *all* users from a location | |
| GET | `/user/location/{id}/type/{role}` | List of *specific* users from a location | |
| GET | `/user/location/{id}/authenticate` | List of users that need to be authenticated in a location | |
| GET | `/user/authenticate` | List of *all* users that require authentication | |
| POST | `/user/authenticate` | Authenticates a *specific* user  | `UserName:{UserName} LocationID:{id}` |
| GET | `/user/revoked` | List of *all* that have rejected/revoked access | |
| GET | `/user/region/{id}` | ~~List of *all* users from a region (//TODO)~~ | |
| GET | `/user/region/{id}/type/{role}` | ~~List of *specific* users from a region (//TODO)~~ | |


## Location

| Method | API | Description |
| --- | --- | --- |
| GET | `/location` | List of *all* locations |
| GET | `/location/detail` | List of *all* locations, with detail |
| GET | `/location/{id}` | *One* location, with detail |
| GET | `/location/region/{id}` | List of *all* locations within a region |
| GET | `/location/region/{id}/detail` | List of *all* locations within a region, with detail |


## Region

| Method | API | Description |
| --- | --- | --- |
| GET | `/region` | List of *all* regions |
| GET | `/region/{id}` | List of *all* locations, within a region (same as `/location/region/{id}`) |


## Area

| Method | API | Description |
| --- | --- | --- |
| GET | `/area` | List of *all* areas |