import React from "react";
import "../Account.css"
import moment from "moment";
import { useAccount } from "App/Api/accapi";
import { FaEdit } from 'react-icons/fa';
import { FaArrowLeft} from 'react-icons/fa';
import "../../../Shared/common-styles/button.css"
import { useNavigate } from "react-router-dom";
import { Card } from "react-bootstrap";


function ProfileSettings (){
  const { data: account}= useAccount();
  const accountDetails = account?.data?.results?.user || {};
    const navigate = useNavigate();
 const fields =[
  {
    label:'Name',
    fieldKey:'name',
    type:'edit'
   },
    {
     label:'Date-of-Birth',
     fieldKey:'dateofbirth',
     type:'edit'
    },
    {
     label:'Country',
     fieldKey:'country',
     type:'edit'
    },
]

const date = moment(accountDetails.date_of_birth).format("DD-MM-YYYY");

    const handleProfileName =() =>{
        navigate("/profile-name")
    }
    const handleProfileDob =() =>{
        navigate("/profile-dob")
    }
    const handleProfileCountry =() =>{
        navigate("/profile-country")
    }
    return (
      <div>
        <div type="submit" className="cd-back"onClick={()=>{navigate("/account")}}>< FaArrowLeft/></div>
      <h2 className="cd-headerStyle">Profile settings</h2>
        {fields.map((field,id)=> (
            <div className="cd-card1" key={id}>
              {field.fieldKey === 'name' ?
              <Card className="cd-cardstyle bg-light mb-3">
                  <Card.Body className="d-flex justify-content-between">
                    {field.label}:{accountDetails.first_name+' '+accountDetails.last_name}
                     <span type ="submit" onClick={() => {handleProfileName()}}><FaEdit /></span>
                  </Card.Body>

                </Card>
               :
               field.fieldKey === 'dateofbirth' ?
                <Card className="cd-cardstyle bg-light mb-3">
                  <Card.Body className="d-flex justify-content-between">
                    {field.label}:{date}
                    <span type ="submit" onClick={() => {handleProfileDob()}}><FaEdit /></span>
                    </Card.Body>
                </Card>
               :
               field.fieldKey === 'country' ?
                <Card className="cd-cardstyle bg-light mb-3">
                  <Card.Body className="d-flex justify-content-between">
                    {field.label}:{accountDetails.country}
                    <span type ="submit" onClick={() => {handleProfileCountry()}}><FaEdit /></span>
                    </Card.Body>
                </Card>

               : null}


            </div>

        ))}


       </div>
    )
}
export default ProfileSettings
