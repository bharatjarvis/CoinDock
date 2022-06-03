import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "../../../Shared/common-styles/common.css";
import "./RecoveryBoxes.css";

// const handleDownload = (e) => {
//   // use mutate for route call
// };

// const handleRecoverboxBlocks = (e) => {};

function RecoveryBoxs(props) {
  console.log(props.label)
  console.log(props.label.recovery_code_length)

  let codeLength = props.label.recovery_code_length
  return (
    <>
<div style={{ marginLeft: '40%', marginTop: '60px', width: '30%' }}>
    <Box color="white" bgcolor="palevioletred" p={1}>
      Greetings from GeeksforGeeks!
    </Box>
    </div>
       {/* <div className="code-box"> */}

        {/* <p className="cd-box-data">strig</p> */}
        {/* <p className="cd-box-index">1</p> */}
        {/* <p>{handleRecoverboxBlocks}</p> */}
        {/* </div> */}
    </>
  );
}
export default RecoveryBoxs;
