import React from "react";
import "Shared/common-styles/common.css";
import "Shared/common-styles/button.css";

import { useGetRecoveryCodesDownloadMutation } from "App/Api/recoveryCodes";

function DownloadRecoverykeys() {
  const [downloadble] = useGetRecoveryCodesDownloadMutation();

  const handleOnClick = () => {
    downloadble();
  };
  return (
    <>
      <button className="cd-button cd-card-button1" onClick={handleOnClick}>
        Download words
      </button>
    </>
  );
}
export default DownloadRecoverykeys;
