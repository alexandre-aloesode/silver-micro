import * as React from "react";
import { useEffect, useState } from "react";
import MenuItem from "@mui/material/MenuItem";
import FormControl from "@mui/material/FormControl";
import Select from "@mui/material/Select";
import InputLabel from "@mui/material/InputLabel";
import CreateRestaurant from "./createRestaurant";
import ManageRestaurant from "./manageRestaurant";
import ManageCalendar from "./manageCalendar";
import ManageImages from "./manageImages";
import { dbGet } from "../../api/database";
import InfoIcon from "@mui/icons-material/Info";
import CalendarMonthIcon from "@mui/icons-material/CalendarMonth";
import ImageIcon from "@mui/icons-material/Image";
import AddCircleIcon from "@mui/icons-material/AddCircle";

export default function restaurants() {
  const [addNewRestaurant, setAddNewRestaurant] = useState(false);
  const [restaurants, setRestaurants] = useState([]);
  const [selectedRestaurant, setSelectedRestaurant] = useState("");
  const [view, setView] = useState(1);
  // const [type, setType] = useState([]);

  useEffect(() => {
    dbGet({
      route: "restaurant",
      params: {
        restaurant_id: "",
        restaurant_name: "",
      },
    }).then((data) => {
      setRestaurants(data);
      setSelectedRestaurant(data[0].restaurant_id);
    });
  }, []);

  return (
    <div>
      {/* {restaurants.length > 1 && ( */}
      <div
        style={{
          display: "flex",
          flexDirection: "row",
          alignItems: "center",
          justifyContent: "center",
          width: "100%",
          marginTop:10,
          marginBottom:10
        }}
      >
        <FormControl
          sx={{
            // width: "100%",
          }}
        >
          <InputLabel id="inputCat">Restaurant</InputLabel>
          <Select
            labelId="inputCat"
            id="inputCat"
            value={selectedRestaurant}
            label="Type de cuisine"
            onChange={(e) => {
              console.log(e.target.value);
              setSelectedRestaurant(e.target.value);
            }}
            required
          >
            {restaurants.map((restaurant) => (
              <MenuItem key={restaurant.restaurant_id} value={restaurant.restaurant_id}>
                {restaurant.restaurant_name}
              </MenuItem>
            ))}
          </Select>
        </FormControl>
        {/* )} */}
      </div>

      {!addNewRestaurant && (
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
            left:"25%"
          }}
        >
          <AddCircleIcon onClick={() => setAddNewRestaurant(true)} />
          <InfoIcon onClick={() => setView(1)} />
          <CalendarMonthIcon onClick={() => setView(2)} />
          <ImageIcon onClick={() => setView(3)} />
        </div>
      )}
      {view == 1 && !addNewRestaurant && <ManageRestaurant restaurant_id={selectedRestaurant} />}
      {view == 2 && !addNewRestaurant && <ManageCalendar restaurant_id={selectedRestaurant} />}
      {view == 3 && !addNewRestaurant && <ManageImages restaurant_id={selectedRestaurant} />}
      {addNewRestaurant && <CreateRestaurant openModal={setAddNewRestaurant} />}
    </div>
  );
}
