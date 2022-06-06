import React from "react";
import Section from "Shared/Section2/Section";
import "Shared/common-styles/space.css";
import "./Logout.css";
function Logout() {
  return (
    <React.Fragment>
      <div className="cd-performance-wrap">
        <Section name="Total BTC" value=" ₿0.00001033" />
        <Section name="Total Primary Currency" value="$26.72" />
        <Section name="Top Performer" value="BTC" />
        <Section name="Low Performer" value="Ethereum" />
      </div>
    </React.Fragment>
  );
}

export default Logout;
