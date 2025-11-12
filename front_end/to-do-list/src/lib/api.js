// Add all our api calls to make everything much cleaner. Add task, Toggle Task, Edit Task, Delete Task

//The base url for making the backend calls.
const BASE_URL = "http://localhost:8000";

// function for adding a task
/**
 * @param {string} title
 */
export async function createTask(title) {
  //Use try catch Network-level or parsing failures.
  try {
    //pause function until server replies with a response.
    //fetch throws error on network problems.
    //
    const response = await fetch(`${BASE_URL}/task`, {
      method: "POST",
      headers: { "Content-type": "application/json" },
      body: JSON.stringify({ title }),
    });

    //Check if server replied successfully.
    //If bad http status 400(Bad request), 404(Not Found) , 500(Internal Server Error)
    if (!response.ok) {
      //Wait until Json ready. .json() is asynchronous. Returns a promise
      //if converting to json fails then we catch and make sure it does crash. Retuen an empty object.
      //*** Need to handle if empty object is returned.
      const err = await response.json().catch(() => ({}));
      //console.log(err);
      throw new Error(err.details || "Failed to add task. ");
      // NEED TO SHOW IN FRONT END
    }
    // if okay
    return await response.json();
  } catch (error) {
    console.error("Error creating taks:", error);
    throw error;
  }
}

// Load the tasks from the server
export async function loadTasks() {
  try {
    const response = await fetch(`${BASE_URL}/tasks`, {
      method: "GET",
      headers: { "Content-type": "application/json" },
    });

    //If error
    if (!response.ok) {
      const err = await response.json().catch(() => ({}));
      console.log(err);
      // throw new Error(err.details || "Failed to add task. ")
    }
    // if okay
    //Wait for Json body to be parsed and return it.
    return await response.json();
  } catch (error) {
    console.error("Could not load tasks:", error);
    throw error;
  }
}

/**
 * @param {any} taskId
 */
export async function deleteTask(taskId) {
  try {
    const response = await fetch(`${BASE_URL}/task/${taskId}`, {
      method: "DELETE",
      headers: { "Content-type": "application/json" },
    });
    //If error
    if (!response.ok) {
      const err = await response.json().catch(() => ({}));
      console.log(err);
      // throw new Error(err.details || "Failed to add task. ")
    }
  } catch (err) {
    console.log(err);
  }
}

/**
 * @param {any} taskId
 */
export async function isCompleted(taskId) {
  try {
    const response = await fetch(`${BASE_URL}/task/${taskId}/toggle`, {
      method: "PATCH",
      headers: { "Content-type": "application/json" },
    });
    //If error
    if (!response.ok) {
      const err = await response.json().catch(() => ({}));
      console.log(err);
      // throw new Error(err.details || "Failed to add task. ")
    }
  } catch (err) {
    console.log(err);
  }
}

/**
 * @param {any} taskId
 */
// @ts-ignore
export async function editTask(taskId, newTitle) {
  try {
    const response = await fetch(`${BASE_URL}/task/${taskId}/edit`, {
      method: "PATCH",
      headers: { "Content-type": "application/json" },
      body: JSON.stringify({ title: newTitle }),
    });
    //If error
    if (!response.ok) {
      const err = await response.json().catch(() => ({}));
      console.log(err);
      // throw new Error(err.details || "Failed to add task. ")
    }

    return await response.json();
  } catch (err) {
    console.log(err);
  }
}
