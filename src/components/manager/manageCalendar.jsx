import * as React from "react";
import { useEffect, useState } from "react";
import { dbPost, dbGet, dbDelete } from "../../api/database";

export default function ManageCalendar(params) {
    const [allHours, setAllHours] = useState([]);
    const [allDays, setAllDays] = useState([]);
    const [schedules, setSchedules] = useState([]);
    const [scheduleArray, setScheduleArray] = useState([]);

    async function checkSchedule(day, hour) {
        const loop = schedules.map((schedule, index) => {
          return new Promise((resolve, reject) => {
            if (schedule.day_id === day && schedule.hour_id === hour) {
              resolve(true);
            } else {
              resolve(false);
            }
          });
        });
        const result = await Promise.all(loop);
        if (result.includes(true)) {
          return true;
        }
        return false;
      }
    
      async function handleClick(day_id, hour_id) {
        let scheduleAlreadyExists = await checkSchedule(day_id, hour_id);
        if (scheduleAlreadyExists == false) {
          const scheduleData = new FormData();
          scheduleData.append("restaurant_id", params.restaurant_id);
          scheduleData.append("day_id", day_id);
          scheduleData.append("hour_id", hour_id);
          const request = await dbPost("restaurant_schedule", scheduleData);
          if (request) {
            getSchedules();
          }
        } else {
          const scheduleData = new FormData();
          scheduleData.append("id", schedules.find((schedule) => schedule.day_id === day_id && schedule.hour_id === hour_id).restaurant_schedule_id);
          scheduleData.append("restaurant_id", params.restaurant_id);
          const request = await dbDelete("restaurant_schedule", scheduleData);
          if (request) {
            getSchedules();
          }
        }
      }

    function getSchedules() {
        dbGet({
          route: "restaurant_schedule",
          params: {
            restaurant_schedule_id: "",
            restaurant_id: params.restaurant_id,
            day_id: "",
            hour_id: "",
          },
        }).then((data) => {
          setSchedules(data);
          let tempScheduleArray = [];
          data.map((schedule, index) => {
            tempScheduleArray.push(schedule.day_id + "-" + schedule.hour_id);
            if (index === data.length - 1) {
              setScheduleArray(tempScheduleArray);
            }
          });
        });
      }

      useEffect(() => {

        getSchedules();

        dbGet({
            route: "hour",
            params: {
              hour_id: "",
              hour_time: "",
              order: "hour_time ASC",
            },
          }).then((data) => {
            setAllHours(data);
          });
      
          dbGet({
            route: "day",
            params: {
              day_id: "",
              day_name: "",
            },
          }).then((data) => {
            setAllDays(data);
          });
      }, [params.restaurant_id]);

    return (
        <div>
        <table
        style={{
          alignItems: "center",
          width: "100%",
          padding: "10px",
          // backgroundColor: "lightgray",
        }}
      >
        <thead>
          <tr>
            <th>Lun</th>
            <th>Mar</th>
            <th>Mer</th>
            <th>Jeu</th>
            <th>Ven</th>
            <th>Sam</th>
            <th>Dim</th>
          </tr>
        </thead>
        <tbody>
          {allHours.map((hour) => {
            return (
              <tr>
                {allDays.map((day) => {
                  return (
                    <td
                      id={"cell" + day.day_id + hour.hour_id}
                      style={{
                        backgroundColor: scheduleArray.includes(day.day_id + "-" + hour.hour_id) ? "lightgreen" : "red",
                      }}
                      onClick={() => {
                        handleClick(day.day_id, hour.hour_id);
                      }}
                    >
                      {hour.hour_time}
                    </td>
                  );
                })}
              </tr>
            );
          })}
        </tbody>
      </table>
    </div>
    )
}