import React from "react";
import "../Account.css";
import { FaArrowLeft} from 'react-icons/fa';
import { FaEdit } from 'react-icons/fa';
import "../../../Shared/common-styles/button.css"
import { useNavigate } from "react-router-dom";
import { useAccount } from "App/Api/accapi";
import { Card } from "react-bootstrap";
function SystemSettings (){
  const { data: account}= useAccount();
  const accountDetails = account?.data?.results?.user || {};
    const navigate = useNavigate();
    const handlePrimary =() =>{
      navigate("/primary")
  }
  const handleSecondary =() =>{
      navigate("/secondary")
  }
  const fields = [
    {
      label:'Primary currency',
      fieldKey:'primarycurrency',
      type:'edit'
    },
    {
     label:'Secondary currency',
     fieldKey:'secondarycurrency',
     type:'edit'
   }
  ]
  return (
    <>
     <div type="submit" className="cd-back"onClick={()=>{navigate("/account")}}>< FaArrowLeft/></div>
    <h2 className="cd-headerStyle">System settings</h2>
      {fields.map((field,id)=> (
          <div className="cd-card1" key={id}>
            {field.fieldKey === 'primarycurrency' ?
              <Card className="cd-cardstyle bg-light mb-3">
                <Card.Body className="d-flex justify-content-between">
                  {field.label}:{accountDetails.primary_currency+' '+accountDetails.primary_currency_symbol}
                  <span type ="submit" onClick={() => {handlePrimary()}}><FaEdit /></span>
                  </Card.Body>
              </Card>
             :
             field.fieldKey === 'secondarycurrency' ?
              <Card className="cd-cardstyle bg-light mb-3">
                <Card.Body className="d-flex justify-content-between p-3">
                  {field.label}:{accountDetails.secondary_currency+' '+accountDetails.secondary_currency_symbol}
                  <span style={{float:"right"}}>
                    <span type ="submit" onClick={() => {handleSecondary()}}><FaEdit /></span></span>
                  </Card.Body>
              </Card>
             : null
              }
          </div>

      ))}


     </>
  )
}
export default SystemSettings
