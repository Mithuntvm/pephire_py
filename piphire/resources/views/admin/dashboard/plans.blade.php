
    @push('styles')
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Muli&display=swap");

* {
  box-sizing: border-box;
}

.plan_master_container {
  font-family: "Muli", sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
    
  height: 600px;
  width: 100%;
  overflow: hidden;
  margin: 0;
}

.plan_container {
  display: flex;
  width: 30%;
  height: 100%;
}

.panel {
  background-size: auto 100%;
  background-position: center;
  background-repeat: no-repeat;
  height: 80%;
  border-radius: 50px;
  color: #fff;
  cursor: pointer;
  flex: 0.5;
  margin: 10px;
  position: relative;
  transition: flex 0.7s ease-in;
  -webkit-transition: all 700ms ease-in;
}

.panel h3 {
  font-size: 24px;
  position: absolute;
  bottom: 20px;
  left: 20px;
  margin: 0;
  opacity: 0;
}

.panel.active {
  flex: 5;
}

.panel.active h3 {
  opacity: 1;
  transition: opacity 0.3s ease-in 0.4s;
}

@media (max-width: 480px) {
  .container {
    width: 100vw;
  }

  .panel:nth-of-type(4),
  .panel:nth-of-type(5) {
    display: none;
  }
}

    </style>
        
    @endpush
    @push('scripts')
        <script>



function createPlans(){
    $("#chart_container").empty();
    $("#chart_container").append(`
        <div id="plans" class="plan_master_container">
        <div class="plan_container">
        <div
            class="panel active"
            style="
            background-image: url('https://images.unsplash.com/photo-1610212570473-6015f631ae96?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            "
        >
            <h3>Explore the world</h3>
        </div>
        <div
            class="panel"
            style="
            background-image: url('https://images.unsplash.com/photo-1606838830438-5f380a664a4e?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1350&q=80');
            "
        >
            <h3>Explore the world</h3>
        </div>
        <div
            class="panel"
            style="
            background-image: url('https://images.unsplash.com/photo-1606059100151-b09b22709477?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1778&q=80');
            "
        >
            <h3>Explore the world</h3>
        </div>
        <div
            class="panel"
            style="
            background-image: url('https://images.unsplash.com/photo-1603048675767-6e79ff5b8fc1?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            "
        >
            <h3>Explore the world</h3>
        </div>
        <div
            class="panel"
            style="
            background-image: url('https://images.unsplash.com/photo-1595433502559-d8f05e6a1041?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            "
        >
            <h3>Explore the world</h3>
        </div>
        </div>
    </div>
    
    
    `)
    const panels = document.querySelectorAll(".panel");

    panels.forEach((panel) => {
    panel.addEventListener("click", () => {
        console.log("active")
        removeActiveClasses();
        panel.classList.add("active");
        });
    });

    const removeActiveClasses = () => {
    panels.forEach((panel) => {
            panel.classList.remove("active");
    });
    };
}




        </script>
    @endpush