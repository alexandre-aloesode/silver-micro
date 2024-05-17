import * as React from "react";
import Box from "@mui/material/Box";
import { Button, TextField } from "@mui/material";
import { useContext, useEffect, useState } from "react";
import { dbGet } from "../../api/database";
import SearchIcon from "@mui/icons-material/Search";
import MenuBookIcon from "@mui/icons-material/MenuBook";
import LocalDiningIcon from "@mui/icons-material/LocalDining";
import PersonIcon from "@mui/icons-material/Person";
import Search from "../client/search";
import Bookings from "../client/bookings";
import Profile from "../global/profile";

export default function ClientHome() {
  const [view, setView] = useState(1);
  const [restaurants, setRestaurants] = useState([]);
  const [userSearch, setUserSearch] = useState("");

  useEffect(() => {
    dbGet({
      route: "restaurant",
      params: {
        restaurant_id: "",
        restaurant_name: "",
        restaurant_type: "",
      },
    }).then((data) => {
      setRestaurants(data);
    });
  }, []);
  return (
    <div>
      <div>
        <TextField
          value={userSearch}
          onClick={ () => {
            setView(2);
          }          
          }
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
      </div>
      <div
        style={{
          display: "flex",
          flexDirection: "row",
          alignItems: "center",
          justifyContent: "center",
          gap: "25px",
          width: "50%",
          position: "absolute",
          bottom: "7px",
          left: "25%",
        }}
      >
        <LocalDiningIcon
          onClick={() => {
            setView(1);
          }}
        />
        <SearchIcon
          onClick={() => {
            setView(2);
          }}
        />
        <MenuBookIcon
          onClick={() => {
            setView(3);
          }}
        />
        <PersonIcon
         onClick={() => {
          setView(4);
         }}
         />
      </div>

      {view == 2 && <Search />}
      {view == 3 && <Bookings />}
      {view == 4 && <Profile />}
    </div>
  );
}
