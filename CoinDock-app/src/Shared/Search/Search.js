import React from "react";
import "./Search.css";
import { Form, FormControl, Button } from "react-bootstrap";

const Search = () => {
  return (
    <div className="input-group rounded">
      <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
      ></link>

      <div className="container">
        <div className="row cd-search-container">
          <div className="col-md-4">
            <div className="input-group rounded">
              <input
                type="search"
                className="form-control rounded"
                placeholder="Search"
                aria-label="Search"
                aria-describedby="search-addon"
              />
              <span className="input-group-text border-0" id="search-addon">
                <i className="fa fa-search"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Search;
