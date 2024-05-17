import ReactDOM from "react-dom";
import { useContext, useEffect, useState } from "react";
import { UserContext } from "./context/userContext";
import ClientHome from "./components/index/clientHome";
import ManagerHome from "./components/index/managerHome";
import AdminHome from "./components/index/adminHome";
import VisitorHome from "./components/index/visitorHome";

export default function Home() {

  const [userRole, setUserRole] = useState("");
  const [userData, setUserData] = useState({});//[user, setUser
  const { user } = useContext(UserContext);

  useEffect(() => {
    if(user?.role){
      setUserRole(user.role);
    }
    else {
      setUserRole("visitor");
    }
  }, [user]);

  return (
    <div
    style={{
      display: "flex",
      width: "100%",
      height: "100%",
      margin: 0,
      overflow: "auto",
    }}
    >
      {userRole == "visitor" && <VisitorHome />}
      {userRole == "client" && <ClientHome />}
      {userRole == "proprietaire" && <ManagerHome />}
      {userRole == "admin" && <AdminHome />}
      {/* {user?.role === "client" ? <ClientHome /> : user?.role === "manager" ?
       <ManagerHome /> : user?.role === "admin" ? <AdminHome /> : null} */}
    </div>
  );
}
