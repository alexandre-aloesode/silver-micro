import React, { useContext, useState } from "react";
import { UserContext } from "../context/userContext";
import { AppRouterProvider } from "../context/router";
import PersonIcon from "@mui/icons-material/Person";
import LogoutIcon from "@mui/icons-material/Logout";

function NavBar() {
  const router = AppRouterProvider();
  const { isAuthenticated, logout } = useContext(UserContext);

  return (
    <div
      style={{
        display: "flex",
        flexDirection: "column",
        width: "100%",
        margin: 0,
        padding: 0,
      }}
    >
      <div
        style={{
          display: "flex",
          justifyContent: "space-between",
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
    </div>
  );
}

export default NavBar;
