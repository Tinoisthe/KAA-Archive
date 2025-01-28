document.addEventListener('DOMContentLoaded', () => {
  const snowflakesCount = 20; // Adjust the number of snowflakes for all devices
  const snowContainer = document.body;

  for (let i = 0; i < snowflakesCount; i++) {
    createSnowflake();
  }

  function createSnowflake() {
    const snowflake = document.createElement('div');
    snowflake.classList.add('snowflake');
    snowflake.innerHTML = '&#10052;'; // Snowflake symbol

    const startPositionX = Math.random() * window.innerWidth;
    const size = Math.random() * 10 + 5; // Snowflakes size range

    snowflake.style.left = `${startPositionX}px`;
    snowflake.style.fontSize = `${size}px`;
    snowflake.style.animationDuration = `${Math.random() * 5 + 5}s`; // Random fall duration

    snowContainer.appendChild(snowflake);

    snowflake.addEventListener('animationiteration', () => {
      snowflake.style.left = `${Math.random() * window.innerWidth}px`;
    });
  }
});
