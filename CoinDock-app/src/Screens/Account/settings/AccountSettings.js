import React from "react";
import "../Account.css";
import { FaArrowLeft} from 'react-icons/fa';
import { FaEdit } from 'react-icons/fa';
import "../../../Shared/common-styles/button.css"
import { useAccount } from "App/Api/accapi";
import { useNavigate } from "react-router-dom";
import { Card } from "react-bootstrap";
function AccountSettings (){
  const { data: account}= useAccount();
  const accountDetails = account?.data?.results?.user || {};
    const navigate = useNavigate();
    const fields= [
      {
        label:'Email',
        fieldKey:'email',
       },
       {
        label:'Change Password',
        fieldKey:'changePassword',
       },
       {
        label:'Recovery Code',
        fieldKey:'recoverycode',
       },

    ]
    const handlePassword =() =>{
        navigate("/apassword")
    }

    return (
      <>
       <div type="submit" className="cd-back"onClick={()=>{navigate("/account")}}>< FaArrowLeft/></div>
      <h2 className="cd-headerStyle">Account settings</h2>
        {fields.map((field,id)=> (
            <div className="cd-card1" key={id}>
              {field.fieldKey === 'email' ?
                <Card
                  className="cd-cardstyle bg-light mb-3"
                 >
                  <Card.Body style={{display:"flex",marginLeft:"6px"}} className="p-2 mt-2">
                    {field.label}:{accountDetails.email}
                  </Card.Body>
                </Card>
               :
               field.fieldKey === 'changePassword' ?
                <Card className="cd-cardstyle bg-light mb-3">
                  <Card.Body className="d-flex justify-content-between">
                    {field.label}
                    <span type ="submit" onClick={() => {handlePassword()}}><FaEdit /></span>
                    </Card.Body>
                </Card>
               :
               field.fieldKey === 'recoverycode' ?
                <Card className="cd-cardstyle bg-light mb-3">
                  <Card.Body className="d-flex justify-content-between">
                    {field.label}
                    <button
                     onClick={() => {navigate("/recovery-codes-account")}}
                     className='cd-card-button1'>Re-Generate</button>
                    </Card.Body>
                </Card>
               : null
                }
            </div>

        ))}


       </>
    )
}
export default AccountSettings
