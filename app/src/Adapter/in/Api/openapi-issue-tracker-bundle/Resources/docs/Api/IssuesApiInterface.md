# OpenAPI\Server\Api\IssuesApiInterface

All URIs are relative to *http://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**issueIdGet**](IssuesApiInterface.md#issueIdGet) | **GET** /issue/{id} | Find issue by ID
[**issueIdPatch**](IssuesApiInterface.md#issueIdPatch) | **PATCH** /issue/{id} | Update issue
[**projectsProjectIdIssuesGet**](IssuesApiInterface.md#projectsProjectIdIssuesGet) | **GET** /projects/{project_id}/issues | Lists project issues
[**projectsProjectIdIssuesPost**](IssuesApiInterface.md#projectsProjectIdIssuesPost) | **POST** /projects/{project_id}/issues | Add a new issue to the project


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.issues:
        class: Acme\MyBundle\Api\IssuesApi
        tags:
            - { name: "open_api_server.api", api: "issues" }
    # ...
```

## **issueIdGet**
> OpenAPI\Server\Model\Issue issueIdGet($id)

Find issue by ID

Displays a single issue

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/IssuesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\IssuesApiInterface;

class IssuesApi implements IssuesApiInterface
{

    // ...

    /**
     * Implementation of IssuesApiInterface#issueIdGet
     */
    public function issueIdGet($id)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **int**| ID of the issue to display |

### Return type

[**OpenAPI\Server\Model\Issue**](../Model/Issue.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **issueIdPatch**
> issueIdPatch($id, $time)

Update issue

Increase time spent on an issue

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/IssuesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\IssuesApiInterface;

class IssuesApi implements IssuesApiInterface
{

    // ...

    /**
     * Implementation of IssuesApiInterface#issueIdPatch
     */
    public function issueIdPatch($id, Time $time)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **int**| ID of the issue to display |
 **time** | [**OpenAPI\Server\Model\Time**](../Model/Time.md)| Time |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **projectsProjectIdIssuesGet**
> OpenAPI\Server\Model\ListIssue projectsProjectIdIssuesGet($projectId)

Lists project issues

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/IssuesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\IssuesApiInterface;

class IssuesApi implements IssuesApiInterface
{

    // ...

    /**
     * Implementation of IssuesApiInterface#projectsProjectIdIssuesGet
     */
    public function projectsProjectIdIssuesGet($projectId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **projectId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ListIssue**](../Model/ListIssue.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **projectsProjectIdIssuesPost**
> OpenAPI\Server\Model\IssueCreated projectsProjectIdIssuesPost($projectId, $createIssue)

Add a new issue to the project

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/IssuesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\IssuesApiInterface;

class IssuesApi implements IssuesApiInterface
{

    // ...

    /**
     * Implementation of IssuesApiInterface#projectsProjectIdIssuesPost
     */
    public function projectsProjectIdIssuesPost($projectId, CreateIssue $createIssue)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **projectId** | **int**|  |
 **createIssue** | [**OpenAPI\Server\Model\CreateIssue**](../Model/CreateIssue.md)| Issue object |

### Return type

[**OpenAPI\Server\Model\IssueCreated**](../Model/IssueCreated.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

