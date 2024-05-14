import * as React from "react";
import Box from "@mui/material/Box";
import { Button, TextField } from "@mui/material";
import { useContext, useEffect, useState } from "react";
import { dbGet } from "../../api/database";
import SearchIcon from "@mui/icons-material/Search";

export default function ClientHome() {
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
    </div>
  );
}
