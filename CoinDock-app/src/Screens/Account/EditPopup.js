import React from 'react';
import Popup from "Screens/Popup/Popup";
import { RiCloseLine } from "react-icons/ri";
import Email from 'Shared/Form/Email';
import Password from 'Shared/Password/Password';
import RecoveryBoxes from 'Shared/Form/RecoveryBoxes';
import { useSelector } from 'react-redux';
import {closeDialogue} from 'App/Auth/reducers/accReducer';
import { useDispatch } from 'react-redux';

const EditPopup =() =>{
const {open, type} = useSelector(state => state.account)
const dispatch = useDispatch();

const handleSetTrigger = () => {
dispatch(closeDialogue());
};
return(
<div>
<form >
  <Popup
    trigger={open}
    setTrigger={handleSetTrigger}
    buttonLable="Done"
  >
    <div className="d-flex justify-content-between">
      <h4>Account settings</h4>
      <RiCloseLine
        size="30px"
        cursor="pointer"
        onClick={() => handleSetTrigger(false)}
      />
    </div>
    { type === 'email' ? 
    <Email/> :
     type === 'changePassword' ? 
    <Password 
      name="password"
      placeholder="Enter your password"
      label="Password"
    /> :
     type === 'regenerateRecoveryWords' ? 
    <RecoveryBoxes
      label="RecoveryWords"
    /> :''}
 
  </Popup>
 </form>
 </div>

)


}
export default EditPopup;