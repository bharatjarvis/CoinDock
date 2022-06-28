import React, { useState } from 'react';
import "./Account.css";
import { openDialogue } from 'App/Auth/reducers/accReducer';
import { useDispatch } from 'react-redux';
import EditPopup from './EditPopup';
import "Shared/common-styles/common.css";
import { useNavigate } from 'react-router-dom';

const Accordion = ({name,items}) => {
  const navigate =useNavigate();
  
    const handleRecoveryButton = () => {
    navigate("/recovery-codes-account");
     };
  const [isActive, setIsActive] = useState(false);
  const dispatch =useDispatch();
  return (
    <div className="cd-accordion">
     <div className="cd-accordion-title" onClick={() => setIsActive(!isActive)}>
          <div>{name} </div>
            <div>{isActive ? '-' : '>'}</div>
          </div>
        
        {isActive && 
        items.map((subitem,id) =>(
         subitem.id ?
         <div className="cd-accordion-content d-flex justify-content-between" key={id}>{subitem.name}:{subitem.value}
         {subitem.type === 'edit'? <button className='cd-button cd-button-2 cd-edit-button' onClick={() => dispatch(openDialogue({type :subitem.key,currentFieldValue: subitem.value}))}>Edit</button> :''}
        </div>
        :
        <div className="cd-accordion-content d-flex justify-content-between" key={id}> {subitem.name}
         {subitem.type === 'edit1'? <button className='cd-button cd-button-2 cd-edit-button' onClick={() => dispatch(openDialogue({type :subitem.key,currentFieldValue: subitem.value}))}>Edit</button> :subitem.key==='regenerateRecoveryWords' ?<button className='cd-button cd-button-2 cd-edit-button' onClick={()=>{handleRecoveryButton()}}>Edit</button>:''}
        </div>))
       } 
      <EditPopup/> 
      </div>
  
    )}

export default Accordion;