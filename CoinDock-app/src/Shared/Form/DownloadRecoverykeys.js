import React from "react";
import "../../Shared/common-styles/common.css";
import "../../Shared/common-styles/button.css";

import {useGetRecoveryCodesDownloadMutation } from "../../App/Api/recoveryCodes";


function DownloadRecoverykeys() {

  const [downloadble] = useGetRecoveryCodesDownloadMutation();

  const handleOnClick = () => {
    downloadble({userId: 1}).then((response) => {
      console.log(response)
      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', response.headers.get('Content-Disposition').split('filename='));
      document.body.appendChild(link);
      link.click();
  });
  };
  return (
    <>
      <button className="cd-button" onClick={handleOnClick}>
        Download words
      </button>
    </>
  );
}
export default DownloadRecoverykeys;
