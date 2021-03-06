<?php
class AccountTest extends CDbTestCase
{
	public $fixtures = array(
		'accounts'=>'Account',
	);

	public function testCreate()
	 {
	 	//CREATE a new account
	 	$newAccount=new Account;
	 	$newAccountName = 'my test santander';
	 	$newAccountType = 'one acc';
	 	$newAccountBalance = '1234.45';
	 	$newAccount->setAttributes(
	 		array(
	 			'user_id'=>1,
	 			'acc_name'=>$newAccountName,
	 			'acc_type'=>$newAccountType,
	 			'acc_balance'=>$newAccountBalance,
	 			'create_time'=>'2013-03-15 00:00:00',
	 			'create_user_id'=>1,
	 			'update_time'=>'2013-03-15 00:00:00',
	 			'update_user_id'=>1	 			
	 		)
	 	);
	 	$this->assertTrue($newAccount->save(false));
	 	
	 	//READ back the newly created account
	 	$retreivedAccount = Account::model()->findByPk($newAccount->id);
	 	$this->assertTrue($retreivedAccount instanceof Account);
	 	$this->assertEquals($newAccountName, $retreivedAccount->acc_name);

	 }
	 
	 public function testRead(){
	 	$retreivedAccount = $this->accounts('account1');
	 	$this->assertTrue($retreivedAccount instanceof Account);
	 	$this->assertEquals('Account name1', $retreivedAccount->acc_name);
	 }
	 
	 public function testUpdate(){
	 	$account = $this->accounts('account2'); //gets the second account from the database (fixture data)
	 	//UPDATE account
	 	$updatedAccountName = 'updated Account name2';
	 	$account->acc_name = $updatedAccountName;
	 	$this->assertTrue($account->save(false));
	 	//read by to test 
	 	$updatedAccount = Account::model()->findByPk($account->id);
	 	$this->assertEquals($updatedAccountName, $updatedAccount->acc_name);
	 }
	 
	 //delete not working as the databse wont delete the account as it violates an integrity - a referenced relation.
	 public function testDelete(){
	 	$account = $this->accounts('account3');//get the third set of fixture data from the database as it does not have an transactions in the fixture data as if it did it would cause a referential integrity error on deletion.
	 	$savedAccountId = $account->id;
	 	$this->assertTrue($account->delete());
	 	$deletedAccount = Account::model()->findByPk($savedAccountId);
	 	$this->assertEquals(NULL, $deletedAccount);
	 }
}
