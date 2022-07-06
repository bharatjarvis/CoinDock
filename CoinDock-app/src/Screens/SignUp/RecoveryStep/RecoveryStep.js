import React, { useState } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import RecoveryBoxs from "Shared/Form/RecoveryBoxes";
import Checkbox from "Shared/Form/CheckBox/CheckBox";
import "Shared/common-styles/common.css";
import Stepper from "Shared/Form/Ellipse/Stepper";
import DownloadRecoverykeys from "Shared/Form/DownloadRecoverykeys";
import "Shared/common-styles/button.css";
import { usePostRecoveryCodesQuery } from "App/Api/recoveryCodes";
import { useNavigate } from "react-router-dom";

function RecoveryCodeBoxStep() {
  const [checked, setChecked] = useState(false);

  const navigate = useNavigate();

  const { data = [] } = usePostRecoveryCodesQuery();

  const handleOnSubmit = () => {
    navigate("/recovery-test");
  };

  const handleOnCheckBoxChange = () => {
    setChecked((checked) => !checked);
  };

  const recoveryCodes = data?.data?.results.recovery_code.recovery_codes;

  return (
    <div className="paper">
      <div className="paper-container">
        <div className="row content d-flex justify-content-center align-items-center">
          <div style={{ height: "100% " }}>
            <div>
              <div className="d-flex justify-content-between"></div>
              <Stepper totalSteps={3} />

              <div className="p-3" />

              <div className="cd-step-header-content">
                Please note down the below recovery words in the same order and
                keep it securely
              </div>

              <div className="p-3" />
              <div className="cd-recover-table">
                {Boolean(recoveryCodes) &&
                  recoveryCodes.map((value, number) => {
                    return (
                      <RecoveryBoxs
                        key={number}
                        index={number + 1}
                        code={value}
                      />
                    );
                  })}
              </div>
              <div className="p-3" />

              <div className="cd-content-row-center">
                <DownloadRecoverykeys />
              </div>

              <div className="p-3" />

              <Checkbox
                label="Yes, I noted down the recovery words securely"
                checked={checked}
                onChange={handleOnCheckBoxChange}
              />

              <div className="p-3" />
              <div className="cd-content-row-end">
                <button
                  className="cd-button cd-button-2"
                  onClick={handleOnSubmit}
                  disabled={!checked}
                >
                  Next
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default RecoveryCodeBoxStep;