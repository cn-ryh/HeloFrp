<?php
class DB
{
  // 定义私有的单例对象
  static private $_instance;
  // 定义私有的连接对象
  private $_pdo;
  // 定义私有的配置信息对象
  private $config = [
    'dsn' => 'mysql:host=123456789;dbname=127.0.0.1;port=3306;charset=utf8',
    'username' => '123456789',
    'password' => '123456789',
    'option' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // 默认是 ：PDO::ERRMODE_SILENT,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
  ];

  // 私有化构造函数
  private function __construct()
  {
  }

  /**
   * @description: 获取单例对象 $_instance
   * @param {*}
   * @return {*}
   * @author {pengzekai}
   */
  static public function getInstance()
  {
    // 判断 $_instance 是否是DB类的实例，即判断 $_instance 是否不为空
    if (!self::$_instance instanceof self) {
      // 为空，则实例化
      self::$_instance = new self();
    }
    return self::$_instance;
  }
  public function connect()
  {
    // 判断 $_pdo 是否存在
    if (!$this->_pdo) {
      try {
        // 不存在则实例化
        $this->_pdo = new PDO($this -> config['dsn'], $this->config['username'], $this -> config['password'], $this -> config['option']);
      } catch (PDOException $e_connect) {
        die('数据库连接失败：' . $e_connect -> getMessage());
      }
    }
    return $this->_pdo;
  }
}