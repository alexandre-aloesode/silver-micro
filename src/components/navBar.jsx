import React, { useContext, useState } from "react";
import { UserContext } from "../context/userContext";
import { AppRouterProvider } from "../context/router";
import PersonIcon from "@mui/icons-material/Person";
import LogoutIcon from "@mui/icons-material/Logout";
import TextField from "@mui/material/TextField";
import SearchIcon from "@mui/icons-material/Search";

function NavBar() {
  const router = AppRouterProvider();
  const { isAuthenticated, logout } = useContext(UserContext);
  const [userSearch, setUserSearch] = useState("");

  return (
    <div
      style={{
        display: "flex",
        flexDirection: "column",
      }}
    >
      <div
        style={{
          display: "flex",
          padding: "10px",
          backgroundColor: "lightgray",
          width: "100%",
          gap: "10px",
        }}
      >
        <button onClick={() => (window.location.href = "/")}>Home</button>
        {/* <button onClick={() => (window.location.href = "/products")}>Products</button> */}
        {isAuthenticated ? (
          <div>
            <PersonIcon />
            <LogoutIcon onClick={logout} />
          </div>
        ) : (
          <div>
            <button onClick={() => (window.location.href = "/login")}>Login</button>
            <button onClick={() => (window.location.href = "/register")}>Register</button>
          </div>
        )}
      </div>
      {/* <div>
        <TextField
          value={userSearch}
          onChange={(e) => {
            setUserSearch(e.target.value);
          }}
          onKeyUp={(e) => {
            if (e.key === "Enter") {
              window.location.href = `/search/${userSearch}`;
            }
          }}
        />
        <SearchIcon
          onClick={() => {
            window.location.href = `/search/${userSearch}`;
          }}
        />
      </div> */}
    </div>
  );
}

export default NavBar;
