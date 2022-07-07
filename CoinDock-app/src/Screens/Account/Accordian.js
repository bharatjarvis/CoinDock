import React, { useState } from 'react';
import "./Account.css";
import { openDialogue } from 'App/Auth/reducers/accReducer';
import { useDispatch } from 'react-redux';
import EditPopup from './EditPopup';
import "Shared/common-styles/common.css";
import { useNavigate } from 'react-router-dom';

const Accordion = ({label,fields,value}) => {
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
          {isActive && fields.map((field,id)=> (
            <div className="cd-accordion-content d-flex justify-content-between" key={id}>
              {field.label}:
              {field.fieldKey=='name' ? value.first_name+' '+value.last_name:
               field.fieldKey == 'dateofbirth' ? value.date_of_birth :
               field.fieldKey=='country'?value.country :
               field.fieldKey=='email'?value.email: null
              }
              {field.type === 'edit' ?
              <button
                className='cd-button cd-button-3 cd-edit-button'
                onClick={() => dispatch(openDialogue({type :field.fieldKey,value}))}>Edit</button>
                :
               field.navigate ?
              <button
                 className='cd-button cd-button-3 cd-edit-button'
                 onClick={()=>{handleRecoveryButton()}}>Edit
               </button> : null }
            </div>
             ))}
      <EditPopup/>
    </div>
)}

export default Accordion;
