import React from "react";
import "./Stepper.css";

function Stepper({ totalSteps, currentActiveSteps }) {
  return (
    <div className="stepper">
      {[...new Array(totalSteps)].map((value, index) => {
        return (
          <React.Fragment key={index}>
            {Boolean(index) && (
              <div
                className="line"
                style={{ width: `calc((100%-32px)/${totalSteps - 1})` }}
              />
            )}
            <div className="stepper-step" />
          </React.Fragment>
        );
      })}
    </div>
  );
}
export default Stepper;
