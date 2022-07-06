import React, { useState } from 'react';
import "./Account.css";
import { openDialogue } from 'App/Auth/reducers/accReducer';
import { useDispatch } from 'react-redux';
import EditPopup from './EditPopup';
import "Shared/common-styles/common.css";
import { useNavigate } from 'react-router-dom';

const Accordion = ({label,field,value}) => {
    const navigate =useNavigate();
    const handleRecoveryButton = () => {
    navigate("/recovery-codes-account");
     };

  const [isActive, setIsActive] = useState(false);
  const dispatch =useDispatch();
  return (
    <div className="cd-accordion">
     <div className="cd-accordion-title" onClick={() => setIsActive(!isActive)}>
          <div>{label}</div>
            <div>{isActive ? '-' : '>'}</div>
          </div>
          {isActive && field.map((i,id)=> (
            <div className="cd-accordion-content d-flex justify-content-between" key={id}>
              {i.label}:
              {i.fieldKey=='name' ? value.first_name+' '+value.last_name:
               i.fieldKey == 'dateofbirth' ? value.date_of_birth :
               i.fieldKey=='country'?value.country :
               i.fieldKey=='email'?value.email: null
              }
              {i.type === 'edit' ?
              <button className='cd-button cd-button-3 cd-edit-button'
                      onClick={() => dispatch(openDialogue({type :i.fieldKey,value}))}>Edit</button>:
               i.navigate ?
                <button className='cd-button cd-button-3 cd-edit-button'
                        onClick={()=>{handleRecoveryButton()}}>Edit</button> : null }
            </div>
             ))}
      <EditPopup/>
    </div>
)}

export default Accordion;
