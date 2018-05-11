<?php
class User_Model_User extends Louis_Db_Table_Abstract {
   
    protected $_name = 'users'; // Khai báo tên table Users
    
    
    public function createUser($username, $password, $firstName, $lastName, $role)
	{
    
    $rowUser = $this->createRow();
    if($rowUser) {
       
        $rowUser->username = $username;
        $rowUser->password = md5($password);
        $rowUser->first_name = $firstName;
        $rowUser->last_name = $lastName;
        $rowUser->role = $role;
        $rowUser->save();
       
        return $rowUser;
    } else {
        throw new Zend_Exception("Không tạo được user!");
		} 
		}

	public static function getUsers()
		{
    $userModel = new self();
    $select = $userModel->select();
    $select->order(array('last_name', 'first_name'));
    return $userModel->fetchAll($select);
	}
	
	public function updateUser($id, $username, $firstName, $lastName, $role)
		{
    $rowUser = $this->find($id)->current();
    if($rowUser) {
       
        $rowUser->username = $username;
        $rowUser->first_name = $firstName;
        $rowUser->last_name = $lastName;
        $rowUser->role = $role;
        $rowUser->save();
 
        return $rowUser;
    }else{
        throw new Zend_Exception("User cập nhật thất bại. Không tìm thấy!");
		}
			 }
			 
	public function updatePassword($id, $password)
	{
    
    $rowUser = $this->find($id)->current();
    if($rowUser) {
       
        $rowUser->password = md5($password);
        $rowUser->save();
    }else{
        throw new Zend_Exception("Mật khẩu cập nhật thất bại.  User không tìm thấy!");
		}
	}	
	
	public function deleteUser($id)
	{

    $rowUser = $this->find($id)->current();
    if($rowUser) {
        $rowUser->delete();
    }else{
        throw new Zend_Exception("Could not delete user.  User not found!");
    }
}

}
