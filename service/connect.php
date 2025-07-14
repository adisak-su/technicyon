<?php
// error_reporting(E_ALL);
date_default_timezone_set('Asia/Bangkok');

require_once("configServer.php");

/**

 * Connect Database

 */

class Database
{
	/** DSN -> Data Source Name */
	private $host;
	private $dbname;
	private $username;
	private $password;
	private $conn;
	private $tb_sales;
	private $tb_autowords;
	private $tb_products;
	private $tb_admins;
	private $tb_customers;
	private $tb_color;
	private $tb_size;
	private $tb_gram;
	private $tb_product_size;
	private $tb_product_color;
	private $tb_product_gram;
	private $tb_product_sale;
	private $tb_customer_price;

	public function __construct()
	{
		global $host;
		global $dbname;
		global $usernameDB;
		global $passwordDB;
		global $tb_sales;
		global $tb_autowords;
		global $tb_products;
		global $tb_admins;
		global $tb_customers;
		global $tb_color;
		global $tb_size;
		global $tb_gram;
		global $tb_product_size;
		global $tb_product_color;
		global $tb_product_gram;
		global $tb_product_sale;
		global $tb_customer_price;

		$this->host = $host;
		$this->dbname = $dbname;
		$this->username = $usernameDB;
		$this->password = $passwordDB;

		$this->tb_sales = $tb_sales;
		$this->tb_autowords = $tb_autowords;
		$this->tb_products = $tb_products;
		$this->tb_admins = $tb_admins;
		$this->$tb_customers = $tb_customers;
		$this->$tb_color = $tb_color;
		$this->$tb_size = $tb_size;
		$this->$tb_gram = $tb_gram;
		$this->$tb_product_size = $tb_product_size;
		$this->$tb_product_color = $tb_product_color;
		$this->$tb_product_gram = $tb_product_gram;
		$this->$tb_product_sale = $tb_product_sale;
		$this->$tb_customer_price = $tb_customer_price;
	}

	public function connect()
	{

		$this->conn = null;

		try {

			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);

			$this->conn->exec("set names utf8");

			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $exception) {

			echo "Database could not be connected: " . $exception->getMessage();
		}
		return $this->conn;
	}

	function getOrderByOrderID($orderNo)
	{
		$params = array(
			'orderNo' => $orderNo
		);

		$sql = "SELECT ordersale.*,customers.address FROM `ordersale`,customers WHERE orderNo=:orderNo AND ordersale.customerID = customers.customerID";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($params);

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (count($result)) {
			$resuleDetail = $this->getDetailOrderByOrderID($orderNo);
			$result[0]['orderDetail'] = $resuleDetail;
			return $result[0];
		} else {
			return null;
		}
	}

	function getDetailOrderByOrderID($orderNo)
	{
		$params = array(
			'orderNo' => $orderNo
		);

		$sql = "SELECT * FROM `detailsale` WHERE orderNo=:orderNo";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($params);

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (count($result)) {
			return $result;
		} else {
			return null;
		}
	}

	function getInvoiceByID($id)
	{
		$params = array(
			'id' => $id
		);

		$sql = "SELECT invoice.*,customers.address FROM `invoice`,customers WHERE invoiceNo=:id AND invoice.customerID = customers.customerID";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($params);

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (count($result)) {
			$resuleDetail = $this->getDetailInvoiceByID($id);
			$result[0]['detail'] = $resuleDetail;
			return $result[0];
		} else {
			return null;
		}
	}

	function getDetailInvoiceByID($id)
	{
		$params = array(
			'id' => $id
		);

		$sql = "SELECT * FROM `ordersale` WHERE invoiceNo=:id";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($params);

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (count($result)) {
			return $result;
		} else {
			return null;
		}
	}

	function insertProductName($product)
	{
		try {
			$sql = "INSERT INTO $this->tb_products (productName) VALUES('$product')";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
		} catch (PDOException $exception) {
			throw $exception;
		}
	}



	function addAutoWord($word)
	{
		$sql = "INSERT INTO $this->tb_autowords VALUE($word)";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
	}

	function getListSale()
	{
		$sql = "SELECT * FROM $this->tb_sales";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if (count($result))
			return $result;
		else
			return null;
	}

	function getListProduct()
	{
		$sql = "SELECT * FROM $this->tb_products WHERE status=1 ORDER BY productOrder";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if (count($result))
			return $result;
		else
			return null;
	}

	function getRunningNo($saleID)
	{
		$params = array(
			'saleID' => $saleID
		);
		$sql = "SELECT runningNo FROM $this->tb_sales WHERE saleID = :saleID";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($params);
		$result = $stmt->fetchAll();
		if (count($result))
			return $result[0]['runningNo'];
		else
			return 0;
	}

	function getSaleDate($saleID)
	{
		$params = array(
			'saleID' => $saleID
		);
		$sql = "SELECT saleDate FROM $this->tb_sales WHERE saleID = :saleID";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($params);
		$result = $stmt->fetchAll();
		if (count($result))
			return $result[0]['saleDate'];
		else
			return 0;
	}

	function getSale($saleID)
	{
		$params = array(
			'saleID' => $saleID
		);
		$sql = "SELECT * FROM $this->tb_sales WHERE saleID = :saleID";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($params);
		$result = $stmt->fetchAll();
		if (count($result))
			return $result[0];
		else
			return null;
	}

	function getSaleFromRunningNo($runningNo)
	{
		$params = array(
			'runningNo' => $runningNo
		);
		$sql = "SELECT * FROM $this->tb_sales WHERE runningNo = :runningNo";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($params);
		$result = $stmt->fetchAll();
		if (count($result))
			return $result[0];
		else
			return null;
	}

	function getListSalePrint()
	{
		$params = array(
			'statusPrint' => 0
		);
		$sql = "SELECT * FROM $this->tb_sales WHERE statusPrint = :statusPrint";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($params);
		$result = $stmt->fetchAll();
		if (count($result))
			return $result;
		else
			return null;
	}

	function updateStatusPrint($runningNo, $val)
	{
		$params = array(
			'runningNo' => $runningNo,
			'val' => $val
		);

		$sql = "UPDATE $this->tb_sales SET statusPrint = $val WHERE runningNo IN $runningNo";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		exit;

		$sql = "UPDATE $this->tb_sales SET statusPrint = :val WHERE runningNo IN :runningNo";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($params);
		exit;
	}

	function updateDataChange($table_name, $record_id, $action, $keyId)
	{
		/*
	CREATE TABLE data_changes (
		id INT AUTO_INCREMENT PRIMARY KEY,
		table_name VARCHAR(50) NOT NULL,
		record_id INT NOT NULL,
		action ENUM('CREATE', 'UPDATE', 'DELETE') NOT NULL,
		changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		changed_by INT NOT NULL,
		data_before JSON,
		data_after JSON
	);
*/
		try {

			$tableName = substr($table_name, 0 ,strlen($table_name)-1);
			$sql = "SELECT * FROM $tableName WHERE $keyId = '$record_id'";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			$params = [
				"table_name" => $table_name,
				"record_id" => $record_id,
				"action" => $action,
				"data_after" => json_encode($result),
			];
			$sql = "INSERT INTO data_changes(table_name,record_id,action,data_after) VALUE(:table_name,:record_id,:action,:data_after)";
			// $stmt = $conn->prepare($sql);
			$stmt = $this->conn->prepare($sql);
			$stmt->execute($params);
		} catch (Exception $ex) {
			throw new Exception($ex);
		}
	}
}
