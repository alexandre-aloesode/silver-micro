import * as React from "react";
import Box from "@mui/material/Box";
import { Button, TextField } from "@mui/material";
import { useContext, useEffect, useState } from "react";
import { dbGet } from "../../api/database";

export default function ClientHome() {
    const [restaurants, setRestaurants] = useState([]);
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
  return(
      <Box>
        <Box>

        </Box>
      </Box>
  ) 
}
