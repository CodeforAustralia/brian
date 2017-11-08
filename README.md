# brian


To access the respective API, assume the host is always the same:

`http://ec2-54-66-246-123.ap-southeast-2.compute.amazonaws.com/brian/src/public/`


#### Client
------

| API | Description |
| --- | --- |
| `/client` | List of **all** offenders |
| `/client/{id}` | Detailed information about offender |
| `/client/{id}?messages=1` | List all correspondence |
| `/client/{id}?community_work=1` | List of *all* assigned community work |
| `/client/{id}?ccs_location=1` | List of *all* assigned locations |
| `/client/{id}?staff=1` | List of *all* assigned staff |
| `/client/{id}?phone=1` | List of *all* offender's phone numbers |


#### Users
------

| API | Description |
| --- | --- |
| `/user` | List of **all** users |
| `/user/{id}` | Detailed information about user (role only?) |
| `/user/types` | List of **all** user types |
| `/user/types/{role}` | List **all** users with a specific role |
| `/user/location/{id}` | List **all** users from a location |
| `/user/location/{id}/types/{role}` | List **specific** users from a location |
| `/user/region/{id}` | List **all** users from a region |
| `/user/region/{id}/types/{role}` | List **specific** users from a region |


#### Location
------

| API | Description |
| --- | --- |
| `/location` | List of **all** locations |
| `/location?detail=1` | List of **all** locations, with detail |
| `/location?location={id}` | **One** location, with detail |
| `/location?region={id}` | List of *all* locations within a region |
| `/location?region={id}&detail=1` | List of *all* locations within a region, with detail |


#### Region
------

| API | Description |
| --- | --- |
| `/region` | List of **all** regions |
| `/region/{id}` | List of **all** locations, within a region (same as `/location?region={id}`) |


#### Area
------

| API | Description |
| --- | --- |
| `/area` | List of **all** areas |