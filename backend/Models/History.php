<?php

namespace Models;

class History
{
    protected $redis;
    protected $db;
    protected $redisKeyPrefix = 'user:';
    protected $redisTTL = 86400; // 1 ngày (TTL trong Redis)

    public function __construct($redisConfig = [])
    {
        $redisConfig = [
            'scheme' => 'tcp',
            'host' => '127.0.0.1',
            'port' => 6379
        ];
        // Kết nối Redis bằng Predis
       // $this->redis = new PredisClient($redisConfig);

        $this->redis = new Predis\Client('tcp://127.0.0.1:6379');

        // // Kết nối MySQL thông qua MysqliDb
        // $this->db = new MysqliDb([
        //     'host' => $dbConfig['host'],
        //     'username' => $dbConfig['username'],
        //     'password' => $dbConfig['password'],
        //     'db' => $dbConfig['dbname'],
        //     'port' => $dbConfig['port'] ?? 3306,
        //     'charset' => 'utf8'
        // ]);
    }

    /**
     * Lưu lịch sử đọc truyện của người dùng
     *
     * @param int $userId
     * @param int $mangaId
     * @param int $chapterId
     * @param int $timestamp
     * @return bool
     */
    public function recordReading($userId, $mangaId, $chapterId, $timestamp = null)
    {
        $timestamp = $timestamp ?: time();
        $redisKey = $this->getRedisKey($userId);

        // Dữ liệu lưu trong Redis
        $data = json_encode([
            'manga_id' => $mangaId,
            'chapter_id' => $chapterId,
            'timestamp' => $timestamp
        ]);

        // Lưu vào Sorted Set với timestamp làm score
        $result = $this->redis->zAdd($redisKey, $timestamp, $data);

        // Đặt TTL cho key
        $this->redis->expire($redisKey, $this->redisTTL);

        return $result;
    }

    /**
     * Lấy lịch sử đọc truyện của người dùng
     *
     * @param int $userId
     * @param int $limit
     * @return array
     */
    public function getReadingHistory($userId, $limit = 10)
    {
        $redisKey = $this->getRedisKey($userId);

        // Lấy danh sách lịch sử từ Redis
        $history = $this->redis->zRevRange($redisKey, 0, $limit - 1);

        // Giải mã JSON thành mảng
        return array_map(function($entry) {
            return json_decode($entry, true);
        }, $history);
    }

    /**
     * Xóa toàn bộ lịch sử đọc của người dùng
     *
     * @param int $userId
     * @return bool
     */
    public function clearReadingHistory($userId)
    {
        $redisKey = $this->getRedisKey($userId);
        return $this->redis->del($redisKey);
    }

    /**
     * Lấy Redis key với prefix
     *
     * @param int $userId
     * @return string
     */
    protected function getRedisKey($userId)
    {
        return $this->redisKeyPrefix . $userId . ':manga_history';
    }

    // /**
    //  * Batch Insert dữ liệu từ Redis vào MySQL
    //  */
    // public function syncToMySQL($userId)
    // {
    //     $redisKey = $this->getRedisKey($userId);
    //     $history = $this->redis->zRange($redisKey, 0, -1);
    //     if (empty($history)) {
    //         return 0;
    //     }

    //     $batchData = [];
    //     foreach ($history as $entry) {
    //         $data = json_decode($entry, true);
    //         $batchData[] = [
    //             'user_id' => $userId,
    //             'story_id' => $data['story_id'],
    //             'chapter_id' => $data['chapter_id'],
    //             'read_time' => date('Y-m-d H:i:s', $data['timestamp'])
    //         ];
    //     }

    //     // Sử dụng MysqliDb để batch insert
    //     $inserted =  History::getDB()->insertMulti('manga_history', $batchData);

    //     if ($inserted) {
    //         // Xóa dữ liệu đã đồng bộ từ Redis
    //         $this->redis->del($redisKey);
    //     }

    //     return $inserted;
    // }
}