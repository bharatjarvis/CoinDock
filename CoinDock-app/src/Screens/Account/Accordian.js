import React, { useState } from 'react';
import "./Account.css";
import { openDialogue } from 'App/Auth/reducers/accReducer';
import { useDispatch } from 'react-redux';
import EditPopup from './EditPopup';
import "Shared/common-styles/common.css";


const Accordion = ({name,items}) => {
  const [isActive, setIsActive] = useState(false);
  const dispatch =useDispatch();
  return (
    <div className="cd-accordion">
     <div className="cd-accordion-title" onClick={() => setIsActive(!isActive)}>
          <div>{name} </div>
            <div>{isActive ? '-' : '>'}</div>
          </div>
        
        {isActive && 
        items.map(subitem =>(
        <div 
        className="cd-accordion-content d-flex justify-content-between" 
        key={subitem.id}>{subitem.name} : {subitem.value}
        {subitem.type === 'edit'? <button className='cd-button cd-button-2 cd-edit-button' onClick={() => dispatch(openDialogue({type :subitem.key,payload:{open :true}}))}>Edit</button> : ''}
       </div>))
       } 
       <EditPopup/> 
      </div>
  
    )}

export default Accordion;