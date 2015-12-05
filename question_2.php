<?php
// Question 2 & 3 & 4

/**
 * Class Customer
 */
abstract class Customer {
  
  const ACCOUNT_TYPE_BRONZE = 'B';
  const ACCOUNT_TYPE_SILVER = 'S';
  const ACCOUNT_TYPE_GOLD = 'G';
  
  // Customer Account types.
  static public $valid_account_types = array(
    Customer::ACCOUNT_TYPE_BRONZE => 'Bronze',
    Customer::ACCOUNT_TYPE_SILVER => 'Silver',
    Customer::ACCOUNT_TYPE_GOLD => 'Gold',
  );
  
  protected $id;
  protected $balance = 0;

  // Customer type id.
  public $customer_type_id;

  /**
   * Constructor - Instantiate abstract method.
   */
  function __construct() {
    $this->deposit();
  }

  public function get_balance() {
    return $this->balance;
  }
  
  // Force Extending class to define this method
    abstract protected function deposit($deposit_amt);
  
  /**
   * Determine if an customer account type is valid.
   * @param int $customer_type_id
   * @return boolean
   */
  static public function isValidCustomerTypeId($customer_type_id) {
    return array_key_exists($customer_type_id, self::$valid_account_types);
  }
  
  /**
   * If valid, set the customer type id.
   * @param int $customer_type_id 
   */
  protected function _setCustomerTypeId($customer_type_id) {
    if (self::isValidCustomerTypeId($customer_type_id)) {
      $this->customer_type_id = $customer_type_id;
    }
  }
  
  /**
   * Load a Customer Account.
   * @param string $customer_id 
   */
  final public static function load($customer_id) {
    $customer_type_id = substr($customer_id, 0, 1);
    $valid_account_type = self::isValidCustomerTypeId($customer_type_id);
    if ($valid_account_type == TRUE) {
        //return $valid_account_type;
        return self::get_instance($customer_type_id);
    }
    else {
        //return $valid_account_type;
        throw new Exception('Customer account type invalid: '.$customer_id);
    }
  }
  
  /**
   * Given an customer_type_id, return an instance of that subclass.
   * @param int $customer_type_id
   * @return Customer subclass
   */
  final public static function get_instance($customer_type_id) {
    $class_name = self::$valid_account_types[$customer_type_id].'Account';
    return new $class_name();
  }
  
  /**
   * Given a valid customer account type id and string length, username is generated.
   * @param string,int $customer_type_id $length
   * @return string $username_string
   */
  final public function generate_username($customer_type_id, $length = 29) {
      $this->customer_type_id = $customer_type_id;
      $alphabets = range('A','Z');
      $numbers = range('0','9');
      $final_array = array_merge($alphabets,$numbers);
      $username_string = '';
      
      while($length--) {
        $key = array_rand($final_array);
        $username_string .= $final_array[$key];
      }
      
      return $customer_type_id.$username_string;

  }
  
  
}

/**
 * Bronze Account class inheriting abstract Customer class
 */
class BronzeAccount extends Customer {
    // Static variable to retain bronze account balance
    private static $bronzebalance = 0;
    
  /**
   * Initialization. 
   */
  public function deposit($bronze_deposit_amt) {
    $this->_setCustomerTypeId(Customer::ACCOUNT_TYPE_BRONZE);
    // No credit change on Bronze Account deposit
    self::$bronzebalance = self::$bronzebalance + $bronze_deposit_amt;
    $display = "The deposited amount is $".$bronze_deposit_amt." and the final balance is $".self::$bronzebalance."<br><br>";
    $this->balance = self::$bronzebalance;    
    return $display;
  }
}

/**
 * Residential . 
 */
class SilverAccount extends Customer {
    // Static variable to retain silver account balance
    private static $silverbalance = 0;
    
  /**
   * Initialization. 
   */
  public function deposit($silver_deposit_amt) {
    $this->_setCustomerTypeId(Customer::ACCOUNT_TYPE_SILVER);
    // 5% extra credit added to Silver Account deposit
    $extra_credit = ($silver_deposit_amt * 5)/100;
    $final_silver_deposit = $silver_deposit_amt + $extra_credit;
    self::$silverbalance = self::$silverbalance + $final_silver_deposit;
    $display = "The deposited amount is $".$silver_deposit_amt." and the final balance is $".self::$silverbalance."<br><br>";
    $this->balance = self::$silverbalance;
    return $display;
  }
}

/**
 * Park . 
 */
class GoldAccount extends Customer {
    // Static variable to retain gold account balance
    private static $goldbalance = 0;
    
  /**
   * Initialization. 
   */
  public function deposit($gold_deposit_amt) {
    $this->_setCustomerTypeId(Customer::ACCOUNT_TYPE_GOLD);
    // 10% extra credit added to Gold Account deposit
    $extra_credit = ($gold_deposit_amt * 10)/100;
    $final_gold_deposit = $gold_deposit_amt + $extra_credit;
    self::$goldbalance = self::$goldbalance + $final_gold_deposit;
    $display = "The deposited amount is $".$gold_deposit_amt." and the final balance is $".self::$goldbalance."<br><br>";
    $this->balance = self::$goldbalance;
    return $display;
  }
}

echo "<h1>Question 2</h1>";
echo '<h2>Bronze Account Deposit and Balance Display.</h2>';
// Testing object 1 for bronze deposit
$account_bronze = new BronzeAccount;
echo "Initial balance: ".$account_bronze->get_balance()."<br>";
echo "User Deposit Value: $100<br>";
echo $account_bronze->deposit(100);

// Testing object 2 for bronze deposit
$account_bronze2 = new BronzeAccount;
echo "Initial balance: ".$account_bronze->get_balance()."<br>";
echo "User Deposit Value: $220<br>";
echo $account_bronze2->deposit(220);

echo '<h2>Silver Account Deposit and Balance Display.</h2>';
// Testing object 1 for silver deposit
$account_silver = new SilverAccount;
echo "Initial balance: ".$account_silver->get_balance()."<br>";
echo "User Deposit Value: $100<br>";
echo $account_silver->deposit(100);

// Testing object 2 for silver deposit
$account_silver2 = new SilverAccount;
echo "Initial balance: ".$account_silver->get_balance()."<br>";
echo "User Deposit Value: $220<br>";
echo $account_silver2->deposit(220);

echo '<h2>Gold Account Deposit and Balance Display.</h2>';
// Testing object 1 for gold deposit
$account_gold = new GoldAccount;
echo "Initial balance: ".$account_gold->get_balance()."<br>";
echo "User Deposit Value: $100<br>";
echo $account_gold->deposit(100);

// Testing object 2 for gold deposit
$account_gold2 = new GoldAccount;
echo "Initial balance: ".$account_gold->get_balance()."<br>";
echo "User Deposit Value: $220<br>";
echo $account_gold2->deposit(220);


echo "<h1>Question 3</h1>";
echo "<h2>Instantiating (using factory get_instance()) Bronze Customer Account with ID: B2345</h2>";
$load_account = Customer::load('B2345');
echo '<tt><pre>' . var_export($load_account, TRUE) . '</pre></tt>';

echo "<h2>Instantiating (using factory get_instance()) Silver Customer Account with ID: S5678</h2>";
$load_account2 = Customer::load('S5678');
echo '<tt><pre>' . var_export($load_account2, TRUE) . '</pre></tt>';

echo "<h2>Instantiating (using factory get_instance()) Gold Customer Account with ID: G1234</h2>";
$load_account3 = Customer::load('G1234');
echo '<tt><pre>' . var_export($load_account3, TRUE) . '</pre></tt>';

echo "<h2>Throwing exception when invalid customer if given: A9876</h2>";
try {
    $load_account4 = Customer::load('A9876');
    echo '<tt><pre>' . var_export($load_account4, TRUE) . '</pre></tt>';
}
catch (Exception $e) {
  echo 'Exception: '.$e->getMessage();
}
echo "<br><br>";
echo "<h1>Question 4</h1>";
echo "<h2>Generating a unique valid username for new bronze customer given the customer ID: B2345</h2>";
try {
    $load_account5 = Customer::load('B2345');
    $user_name = $load_account5->generate_username($load_account5->customer_type_id,29);
    echo 'Username for '.get_class($load_account5).' with customer ID: B2345'.$user_name;
}
catch (Exception $e) {
    echo 'Exception generating username: '.$e->getMessage();
}

echo "<h2>Generating a unique valid username for new silver customer given the customer ID: S5678</h2>";
try {
    $load_account6 = Customer::load('S5678');
    $user_name2 = $load_account6->generate_username($load_account6->customer_type_id,29);
    echo 'Username for '.get_class($load_account6).' with customer ID: S5678'.$user_name2;
}
catch (Exception $e) {
    echo 'Exception generating username: '.$e->getMessage();
}

echo "<h2>Generating a unique valid username for new gold  customer given the customer ID: G1234</h2>";
try {
    $load_account7 = Customer::load('G1234');
    $user_name3 = $load_account6->generate_username($load_account7->customer_type_id,29);
    echo 'Username for '.get_class($load_account7).' with customer ID: G1234'.$user_name3;
}
catch (Exception $e) {
    echo 'Exception generating username: '.$e->getMessage();
}

echo "<h2>Throwing exception generating username for invalid customer ID: A9876</h2>";
try {
    $load_account8 = Customer::load('A9876');
    $user_name4 = $load_account6->generate_username($load_account8->customer_type_id,29);
    echo 'Username for '.get_class($load_account8).' with customer ID: A9876'.$user_name4;
}
catch (Exception $e) {
    echo 'Exception generating username: '.$e->getMessage();
}
