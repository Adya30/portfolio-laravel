<style>
    @media (hover: hover) and (pointer: fine) {
        :root {
            --cursor-default: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAM9SURBVFhHxZdLaBNBGMd3k9RkNwpGNiGLJkXwoCdBFFHUoAhaPfgsCIq1Up8XJQe9KVrxcVFR8FURETz0oCIqCNpWfNCiUkFoNU2b1narlbY22Hbb7iYzft/s9kVrm8Zk/cOf2Z2dxy/fzM5+4Xiej+XYbIXc/xLPcwNQJMFbWIXVEp18y8ndrg67jSNwu9WotVZKvMLb87B4BoVrjMQ2VmuhlNpXskrbZtPbYXcP3CNEPntikZTacn8v7cilpFFOlIRFhIBo2C2LhAHwM0gTzUFKYnKyJOzuhXrcnOtYiyzLAGgLUi0WMCAgErfCbhWe9YPXs1ZZ1CgAtG5G4sYREfeDBs5jLbOkMQBDkWiQyZXDIkYCITay1lnQuABaowkRk/VLh0TcEzpnt2cFYnwA02YkEiYEbsyVrFcGNSHAUCQA4vJBthzd4FWsZ4Y0MQB6BMTFA6IOfTAaIdY7A5ocAG1C0KhMLxQJCeiHEKvZCP+o1ADQg5GI+hNn9gi4HCpszDXGMOkrdQD0IES9Xzch+jjOscIYKj1NDQANEMlhCADg4uAlbLQ01FxTNkUA9PBy6MUFAp6Y6UE8uyc19tYFSKJpnEkm8yBExE9O7BIwoUGIpWzgVFVR6o2p9QGi/wUgCfW0K5fSOBjLX6Y7we2m4Zo0yeR0gYAfr26Hw7HMGD01fRuzBPDLsKQK/LqWQOL6WY92tdhDb56fpZdek+ijEqnv6V2p//UDn1b52KdWP/fT6DtZbS+XtKI8J+QTfI/L5Vhujj+pRm/CJigjcyip9FHy2TewdxNbXwX8AlwGrgZXgb+CI+A6cCe4VRT4ft9M228eEhpIdpuhLiUNA+DkUZj8jURJlZTct8GJX0GcfC5rOUKhUMgBhRMsgCWwF4zt5uXkcIugXAhOSQYArKVWD5O/9VLyXtLC+QImqd85btp8o1n2BEkpAPwI0iRO/kFKHtvBNlMHeAFrkWUptS8B4BOs+UdJP1UoYti7wIvZUwukfLnvUUmNl5zbL+Kphp9byyZHKfEnnu47x6djsoFne0a+cCnL7eJbj2534XrjSbaWVVopeF8xwcB3fTOrsFrw97zBZrPtNG8tFsf9AZKe/ut982c1AAAAAElFTkSuQmCC') 3 2, auto;
            --cursor-pointer: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAASqSURBVFhHzddrTFt1GAbwQim0pRcKPYVBWxiXABtuYjZvHxxxMSpuhsiGJCbeEpdoNEaNt2i8bLr5xcGyuMkXHBDjNg2XMVzijFOCg7iL21yiIjAmF+W+CZNwmY/Pe9oeCdtCi1Z9k98Hyun5P/1fz9H9n+smOkitVEsb6F+rPBomzPM6RVLY6z1CXrYB2zc7sG6tERERERJgmqRnwloRdJSw620H8EcaJn50I2upIdALT1IUyXVhKQN9S6gpjwfGvJjucmPViuhAgM1kJz2FpaLpBGHPdl+AyZ/cuCFPC7CFFJKgYSkJcJKuFeAtcpFcF5YKJoD0wH8W4DUyUdjqygDtbqzI0VZBF20j6YWwlBagqowBRry43OvBmpuNgQABbbTR7x/fG44RqiXAEAP0ePDDkSWoeCceDxRZEBOtbkrzfUzFdB9dT4uuu2iIsH93AnAxFVMdbrUnMJkKzKShZkc8og0RSFL0yM00cJe8IozsmFWUQCHVnTRF6o3uuC0G/SeTgVEvaisUbCg0ofReI0rXG5HojET5G+yhC6nYuSVe3apNRh2y06Og12tBGiiWgq5mQv5yA/KX+SZdwY0xmPnFi+ceswduqoqO0qGk0IzvWhLRWq/g6UetaNrjxMWOFByoVOCw6QPXFlJQJfv7acLeXU5c6veg4NYY9SYf7UzAeJcHrXUutDUoOH7YhfW3m7UwwmLSYesLPDuQpvbK6pW+79JLZKQFT1EJoM7+D8t8N2qqcqo3eeR+C4eB4z/IeSA4Lw5Vu9QhKb47BiUclgyPHulUWmTExnti4IiLDASQsyOe5P4LViOhuCAKXY1WnPvKhYw0A1583A4MeDFzzq0eTNOdnJR9Hn5Gg3QpFa8+FRdocL7A2RHUzilLaJagWHVYe0s0juxPxAQbnO12Y6bbo5EgEkjMnndj5EwKjta78E2jgq85VNkZ2sYlAUI6O56gPlJvoC5Fjqn86t9aFYw1OzD5/RLMnPcH8fcKuFdgmMPDoZo9oyA/SxuCkALIRJGxWkM95NuOuQwnTij4tS4WA/UWDDVZMX5MwVR7sm9IGGKqIxm/n03CeEsC+utMWJmhDUFIp6c85QgHqStij387HvvSoTY+yLkxeMCKgQYLhg/ZMPp5HEa/cGDkMxv/Z8HIQSv66sy47q8Ab1LIx7csG9+B5A8gjWgB/Ab8QeTzgQZfsAsM1bnPjEy3FuB5Cvn4lovVx7JqbrvXCnA1E4dtaK0wq/sCvy9b8sMkPRDUMgyUPO8dJ+zexj2BR3KwAS4327F1k7YCOqmAkijkZ0h5GcGDxbHqxjPdFo9Rju/opxz3ecbY7eOcA2ix41SlCW5F6/5KWkZOCvl9ooTUU+/ZTTac3mdH114TemvN6JmjlxOu+xMzTn1gRtUrJuSmao130DrKJguFXDJm75N6Q7s1Alkevqws1WH5HHnpOuSwUadda1i0k4x9PqXQop+g5fn/GTpLMqHmNnI1P1MNFdEqyiQ5jhf1EiNfkuTSffJLHqKX6V0qpzK/HSTPiBJUGl5Ncn06WelvvUtKCFmSNpK17KUsyiWZXAHyd46fNCzXypPzAo3rdH8C1WgQSONf0t4AAAAASUVORK5CYII=') 8 2, pointer;
        }

        html, body, div, section, article, header, nav, footer, main, p, span, h1, h2, h3, h4, h5, h6, ul, li, img, aside, figure, table, tr, td, th {
            cursor: var(--cursor-default) !important;
        }

        a, button, [role="button"], input[type="submit"], input[type="button"], select, label[for], summary, .cursor-pointer {
            cursor: var(--cursor-pointer) !important;
        }

        input[type="text"], input[type="email"], input[type="password"], input[type="number"], input[type="search"], textarea, [contenteditable="true"] {
            cursor: text !important;
        }

        [disabled], .cursor-not-allowed {
            cursor: not-allowed !important;
        }
    }
</style>
