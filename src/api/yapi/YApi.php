<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/14
 * Time: 9:10
 */

namespace ApiGenerator\api\yapi;


use ApiGenerator\config\YapiOpt;

class YApi
{
    use GuzzleClientTrait;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var int
     */
    protected $projectId;

    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->baseUrl   = YapiOpt::$baseUrl;
        $this->projectId = YapiOpt::$projectId;
        $this->token     = YapiOpt::$token;
    }


    /**
     * 获取项目基本信息
     *
     * @param string|null $token
     * @return array
     * @throws YApiException
     */
    public function getProject(string $token = null)
    {
        return $this->get('/api/project/get', [
            'token' => $token ?? $this->token
        ]);
    }

    /**
     * 新增接口菜单/分组
     *
     * @param string $name
     * @param string $projectId
     * @param string|null $desc
     * @param string|null $token
     * @return array
     * @throws YApiException
     */
    public function createApiGroup(
        string $name,
        string $desc = null,
        string $projectId = null,
        string $token = null
    ) {
        return $this->post('/api/interface/add_cat', [
            'name' => $name,
            'desc' => $desc,
            'project_id' => $projectId ?? $this->projectId,
            'token' => $token ?? $this->token
        ]);
    }

    /**
     * 获取菜单列表/分组
     *
     * @param string|null $projectId
     * @param string|null $token
     * @return array
     * @throws YApiException
     */
    public function getApiGroups(
        string $projectId = null,
        string $token = null
    ) {
        return $this->get('/api/interface/getCatMenu', [
            'project_id' => $projectId ?? $this->projectId,
            'token' => $token ?? $this->token
        ]);
    }

    /**
     * 获取接口数据
     *
     * @param int $id
     * @param string|null $token
     * @return array
     * @throws YApiException
     */
    public function getApi(int $id, string $token = null)
    {
        return $this->get('/api/interface/get', [
            'id' => $id,
            'token' => $token ?? $this->token
        ]);
    }

    /**
     * 获取接口列表数据
     *
     * @param int $projectId
     * @param int $page
     * @param int $limit
     * @return array
     * @throws YApiException
     */
    public function getApis(int $projectId, int $page = 1, int $limit = 10)
    {
        return $this->get('/api/interface/list_cat', [
            'project_id' => $projectId,
            'page' => $page,
            'limit' => $limit,
            'token' => $token ?? $this->token
        ]);
    }

    /**
     * 获取某个分类下接口列表
     *
     * @param int $groupId
     * @param int $page
     * @param int $limit
     * @return array
     * @throws YApiException
     */
    public function getApisByGroupId(int $groupId, int $page = 1, int $limit = 10)
    {
        return $this->get('/api/interface/list_cat', [
            'catid' => $groupId,
            'page' => $page,
            'limit' => $limit,
            'token' => $token ?? $this->token
        ]);
    }

    /**
     * 更新接口
     *
     * @param int $groupId
     * @param array $payload
     * @param string|null $token
     * @return array
     * @throws YApiException
     */
    public function updateOrCreateApi(int $groupId, array $payload = [], string $token = null)
    {
        return $this->post('/api/interface/save', array_merge([
            'token' => $token ?? $this->token,
            'catid' => $groupId,
        ], $payload));
    }

    /**
     * 导入数据
     *
     * @param string $data
     * @param string $merge
     * @param string|null $url
     * @param string|null $token
     * @return array
     * @throws YApiException
     */
    public function importData(string $data, string $merge, string $url = null, string $token = null)
    {
        return $this->postForm('/api/open/import_data', [
            'type' => 'swagger',
            'json' => $data,
            'merge' => $merge,
            'url' => $url,
            'token' => $token ?? $this->token
        ]);
    }

}