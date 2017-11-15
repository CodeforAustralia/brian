# brian


To access the respective API, assume the host is always the same:

`http://ec2-54-66-246-123.ap-southeast-2.compute.amazonaws.com/brian/src/public/`

## Mail

| Method | API | Description | Body |
| --- | --- | --- | --- |
| POST | `/mail` | `To:{string}` <br/> `ToName:{string}` <br/> `From:{string}` <br/> `FromName:{string}` <br/> `Subject:{string}` <br/> `Body:{string}` |


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


## Staff (includes Admins)

| Method | API | Description | Body |
| --- | --- | --- | --- |
| GET | `/staff` | List of *all* authenticated CCS staff | |
| GET | `/staff/location/{id}` | List of *all* authenticated CCS staff from a location | |
| GET | `/staff/{username}/client` | List of *all* offenders assigned to CM | |
| GET | `/staff/{username}/client/location/{id}` | List of offenders assigned to CM from a location | |
| GET | `/staff/type/{role}` | List of *all* users with a specific role | |
| GET | `/staff/location/{id}/type/{role}` | List of *specific* users from a location | |
| GET | `/staff/location/{id}/authenticate` | List of users that need to be authenticated in a location | |
| GET | `/staff/authenticate` | List of *all* users that require authentication | |
| POST | `/staff/authenticate` | Sets the authentication of a *specific* user  | `Username:{string}` <br/> `LocationID:{int}` <br/> `Admin:{string}` <br/> `Status:{0=waiting,1=approved,2=denied}` |
| GET | `/staff/revoked` | List of *all* that have rejected/revoked access | |
| POST | `/staff/delete` | Deletes a *specific* user  | `Username:{string}` <br/> `LocationID:{int}` |
| GET | `/staff/region/{id}` | ~~List of *all* users from a region (//TODO)~~ | |
| GET | `/staff/region/{id}/type/{role}` | ~~List of *specific* users from a region (//TODO)~~ | |


## Users

| Method | API | Description | Body |
| --- | --- | --- | --- |
| GET | `/user` | List of *all* users | |
| POST | `/user/new` | Create a new user | `Username:{string}` <br/> `Password:{string}` <br/> `email:{string}` <br/> `Role:{string}` <br/> `Location:{int}` <br/> `FirstName:{string}` <br/> `LastName:{string}` |
| POST | `/user/password` | Update password (//TODO, not sure what this means yet) | |
| GET | `/user/{username}` | Detailed information about *one* user (role only?) | |
| POST | `/user/{username}` | Assigns a user a *specific role* | `Role:{string}` |
| GET | `/user/type` | List of *all* user types | |
| POST | `/user/delete` | Deletes a *specific* user  | `Username:{string}` <br/> `LocationID:{int}` |


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